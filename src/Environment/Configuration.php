<?php

namespace Akipe\Kif\Environment;

use Symfony\Component\Dotenv\Dotenv;

class Configuration
{
  public const STRUCTURE_NAME = "KIF_STRUCTURE_NAME";

  private Dotenv $configLoader;

  public function __construct()
  {
    $this->configLoader = new Dotenv();
    $this->configLoader->loadEnv(__DIR__.'/../../.env');
  }

  public function getStructureName(): string
  {
    return $_ENV[self::STRUCTURE_NAME];
  }
}
