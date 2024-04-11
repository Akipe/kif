<?php

namespace Akipe\Kif\Html;

class HtmlGenerator
{
    private string $style;
    private string $tabHeader;
    private string $tabContent;

    public function __construct() {
        $this->style = "";
        $this->tabHeader = "";
        $this->tabContent = "";
    }

    public function setStyle(string $style): void {
        $this->style = $style;
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

    public function generateTabPageTemplate(string $cssFilePath): string {
        return "<!doctype html>
        <html>
            <head>
                <link rel=\"stylesheet\" type=\"text/css\" href=\"" . $cssFilePath . "\" />
            </head>
            <body>
                <h1>Relevé de compte</h1>
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