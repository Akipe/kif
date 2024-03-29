<?php

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

    public function addTabLine(... $elements): void {
        $this->tabContent .= "<tr>". PHP_EOL;

        foreach ($elements as $element) {
            $this->tabContent .= "<th>". $element . "</th>". PHP_EOL;
        }

        $this->tabContent .= "</tr>". PHP_EOL;
    }

    public function generateTabPageTemplate(): string {
        return "<!doctype html>
        <html>
            <head>
                <style>
                    ". $this->style . "
                </style>
            </head>
            <body>
                <table>
                    <thead>
                        ". $this->tabHeader . "
                    </thead>
                    <tbody>
                        ". $this->tabContent . "
                    </tbody>
                </table>
            </body>
        </html>
        ";
    }
}