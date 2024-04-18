<?php

namespace Akipe\Lib\Html;

class HtmlGenerator
{
  private string $style;
  private string $tabHeader;
  private string $tabContent;
  private string $title;
  private string $information;

  public function __construct() {
    $this->style = "";
    $this->tabHeader = "";
    $this->tabContent = "";
    $this->title = "";
    $this->information = "";
  }

  public function setStyle(string $style): void {
    $this->style = $style;
  }

  private function getStyle(): string {
    return $this->style;
  }

  public function setTitle(string $title): void {
    $this->title = $title;
  }

  public function setInformation(string $information): void {
    $this->information = $information;
  }

  /**
   *
   * @param string $elements
   * @return void
   */
  public function setTabHeader(... $elements): void {
    $this->tabHeader .= "<tr>". PHP_EOL;

    foreach ($elements as $element) {
      $this->tabHeader .= "<th>". $element . "</th>". PHP_EOL;
    }

    $this->tabHeader .= "</tr>". PHP_EOL;
  }

  /**
   *
   * @param array<array{classCss: string, data: string}> $elements
   * @return void
   */
  public function addTabLine(... $elements): void {
    $this->tabContent .= "<tr>". PHP_EOL;

    foreach ($elements as $element) {
      $this->tabContent .= "<th class=\"". $element["cssClass"] ."\">". $element["data"] . "</th>". PHP_EOL;
    }

    $this->tabContent .= "</tr>". PHP_EOL;
  }

  public function generateCssStyle(): string {
    return $this->style;
  }

  public function generateTabPageTemplate(): string {
    return "<!doctype html>
    <html>
      <head>
        <style>
          ". $this->getStyle() ."
        </style>
      </head>
      <body>
        <h1 class=\"releve-compte-titre\">". $this->title . "</h1>
        <p class=\"releve-compte-information\">". $this->information . "</p>
        <table class=\"releve-compte-tableau\">
          <thead class=\"releve-compte-tableau-titre\">
            ". $this->tabHeader . "
          </thead>
          <tbody class=\"releve-compte-tableau-contenu\">
            ". $this->tabContent . "
          </tbody>
        </table>
      </body>
    </html>
    ";
  }
}
