<?php

namespace Akipe\Kif\Environment;

use Symfony\Component\Dotenv\Dotenv;

class Configuration
{
    public const CONFIGURATION_FILE_PATH = __DIR__ . '/../../.env';
    public const PROPERTY_STRUCTURE_NAME = "KIF_STRUCTURE_NAME";

    private Dotenv $configLoader;

    public function __construct()
    {
        $this->configLoader = new Dotenv();
        $this->configLoader->loadEnv(self::CONFIGURATION_FILE_PATH);
    }

    public function getStructureName(): string
    {
        return $_ENV[self::PROPERTY_STRUCTURE_NAME];
    }
}
