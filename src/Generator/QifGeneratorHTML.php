<?php

namespace Akipe\Kif\Generator;

use IntlDateFormatter;
use Akipe\Kif\Element\QifAccount;
use Akipe\Kif\Environment\Configuration;
use Akipe\Kif\Html\HtmlGenerator;

class QifGeneratorHTML
{
  private HtmlGenerator $generator;
  private IntlDateFormatter $dateFormater;
  private Configuration $configuration;

  public function __construct(
    public readonly QifAccount $account,
  ){
    $this->generator = new HtmlGenerator();
    $this->setDateFormater();
    $this->configuration = new Configuration();
  }

  private function setDateFormater(): void {
    $this->dateFormater = new IntlDateFormatter(
      'fr_FR',
      IntlDateFormatter::NONE,
      IntlDateFormatter::NONE
    );
    $this->dateFormater->setPattern('EEEE dd MMMM YYYY'); // Exemple : "jeudi 20 février 2020"
  }

  /**
   *
   * @return array{html: string, css: string}
   */
  public function generate(string $cssFilePath): array {
    $this->generator->setStyle(
      file_get_contents(__DIR__ . "/style.css")
    );

    $startDateFormated = $this->dateFormater->format(
      $this->account->getFirstTransactionDate()
    );
    $endDateFormated = $this->dateFormater->format(
      $this->account->getLastTransactionDate()
    );

    $this->generator->setTitle(
      "Relevé de \"" . $this->account->name . "\" - ". $this->configuration->getStructureName()
    );
    $this->generator->setInformation(
      "Du ". $startDateFormated ." au ". $endDateFormated ." avec un solde de ". $this->account->amountStart ." € à ". $this->account->getClosingAmount() ." €"
    );

    $this->generator->setTabHeader(
      "Date",
      "Tiers",
      "Remarque",
      "Débit",
      "Crédit",
      "Solde",
    );

    foreach ($this->account->transactions as $transaction) {
      if ($transaction->amount < 0) {
        $debit = [
          "cssClass" => "debit",
          "data" => number_format($transaction->amount, 2, ',', ' '),
        ];
        $credit = [
          "cssClass" => "credit",
          "data" => '',
        ];
      } else {
        $debit = [
          "cssClass" => "debit",
          "data" => '',
        ];
        $credit = [
          "cssClass" => "credit",
          "data" => number_format($transaction->amount, 2, ',', ' '),
        ];
      }

      $this->generator->addTabLine(
        [
          "cssClass" => "date",
          "data" => $transaction->date->format("d/m/Y"),
        ],
        [
          "cssClass" => "recipient",
          "data" => ucwords($transaction->recipient),
        ],
        [
          "cssClass" => "note",
          "data" => ucwords($transaction->note),
        ],
        $debit,
        $credit,
        [
          "cssClass" => "balance",
          "data" => number_format($transaction->getBalance(), 2, ',', ' '),
        ],
      );
    };

    return [
      "css" => $this->generator->generateCssStyle(),
      "html" => $this->generator->generateTabPageTemplate($cssFilePath),
    ];
  }
}
