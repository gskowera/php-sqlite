<?php

namespace App;

use Exception;

class Validate
{
    private $invalid = [];

    private $model;
    
    /**
     * Only for POST requests
     * 
     * @param array  $modelRules
     * @return bool
     */
    public function __construct($model)
    {
        $this->model = $model;
        
        return $this;
    }

    public function parse()
    {
        foreach ($this->model::$rules as $field => $rules) {
            foreach ($rules as $rule) {
                if (!isset($_POST[$field])) {
                    continue;
                }

                if (!method_exists(__CLASS__, $rule)) {
                    throw new Exception('Reguła walidacji ' . $rule . ' nie została zdefiniowna.');
                }

                $this->$rule($_POST[$field], $field);
            }
        }

        return $this;
    }

    public function valid()
    {
        return !count($this->invalid);
    }

    public function invalidInfos()
    {
        return $this->invalid;
    }
    
    private function require($value, $name): bool
    {
        $valid = (!empty($value) && strlen($value) > 0);

        if (!$valid) {
            $this->invalid[] = 'Pole ' . $this->model::$columns[$name] . ' jest wymagane.';
        }

        return $valid;
    }

    private function mobile($value, $name): bool
    {
        $valid = preg_match('/^[0-9]{3}-?[0-9]{3}-?[0-9]{3}$/', $value);

        if (!$valid) {
            $this->invalid[] = 'Pole ' . $this->model::$columns[$name] . ' musi mieć postać 123-456-789.';
        }

        return $valid;
    }

    private function email($value, $name): bool
    {
        $valid = (filter_var($value, FILTER_VALIDATE_EMAIL));

        if (!$valid) {
            $this->invalid[] = 'Pole ' . $this->model::$columns[$name] . ' musi być adresem e-mail.';
        }

        return $valid;
    }
}
