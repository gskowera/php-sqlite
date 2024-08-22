<?php

namespace App;

use Exception;
use SQLite3;
use App\Config;

class Database
{
    private static $_instance = null;

    private $dbh;
    private $statement;

    private function __construct()
    {
        try {
            $database = Config::of('database')->filename;
            $this->dbh = new SQLite3($database);
            $this->dbh->exec("PRAGMA busy_timeout = 9900");
            $this->dbh->exec("PRAGMA encoding = \"UTF-8\"");
        } catch (Exception $e) {
            echo 'Cannot connect to database! <br /><br />' . $e->getMessage();
        }
    }

    public static function instance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->dbh->prepare($sql);

        if (!$stmt) {
            throw new Exception($this->dbh->lastErrorMsg());
        }

        foreach ($params as $key => $value) {
            switch (true) {
                case is_int($value):
                    $type = SQLITE3_INTEGER;
                    break;
                case is_float($value):
                    $type = SQLITE3_FLOAT;
                    break;
                case is_bool($value):
                    $type = SQLITE3_BLOB;
                    break;
                case is_null($value):
                    $type = SQLITE3_NULL;
                    break;
                default:
                    $type = SQLITE3_TEXT;
            }
            $stmt->bindValue("$key", $value, $type);
        }
        $this->statement = $stmt->execute();

        return $this;
    }

    public function fetch()
    {
        $data = [];
        while ($row = $this->statement->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }


    public function affectedRows()
    {
        return $this->statement->changes();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertRowID();
    }

    public function begin()
    {
        return $this->dbh->exec("BEGIN");
    }

    public function commit()
    {
        return $this->dbh->exec("COMMIT");
    }

    public function rollback()
    {
        return $this->dbh->exec("ROLLBACK");
    }

    public function __destruct()
    {
        $this->dbh = null;
    }
}
