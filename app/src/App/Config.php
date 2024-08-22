<?php

namespace App;

use Exception;

class Config
{
    public static function of($configType)
    {
        $configFilename = CONFIG_DIR . '/' . $configType . '.php';

        if (!file_exists($configFilename)) {
            throw new Exception('Config file: ' . $configType . ' does not exist!');
        }

        return require($configFilename);
    }
}
