<?php

namespace Models;

use App\Database;

class Address
{
    public static $table = 'addresses';

    public static $primaryColumn = 'id';

    public static $columns = [
        'id' => 'ID',
        'firstname' => 'Imię',
        'lastname' => 'Nazwisko',
        'mobile' => 'Telefon',
        'email' => 'Adres e-mail',
        'address' => 'Adres zamieszkania',
    ];

    public static $rules = [
        'firstname' => ['require'],
        'lastname' => ['require'],
        'mobile' => ['mobile'],
        'email' => ['email', 'require'],
    ];

    public static function getDataColumns(): array
    {
        return array_filter(self::$columns, function ($key) {
            return $key !== self::$primaryColumn;
        }, ARRAY_FILTER_USE_KEY);
    }
}
