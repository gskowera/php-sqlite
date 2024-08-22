<?php

namespace Actions;

use Models\Address as ModelsAddress;
use App\Database;
use App\Validate;
use Exception;

class Address
{
    private array $message = [];
    private string $sql;
    private array $params = [];
    private string $reloadLocation = PUBLIC_URL . '/index.php';

    public function row(int $id): array
    {
        $this->sql = "SELECT * FROM `addresses` WHERE `id` = :id";
        $this->params['id'] = $id;

        try {
            $result = Database::instance()
                ->query($this->sql, $this->params)
                ->fetch();
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return (count($result))
            ? $result[0] : [];
    }

    public function add(): void
    {
        try {
            $validate = (new Validate(ModelsAddress::class))
                ->parse();

            if (!$validate->valid()) {
                $message = 'Nie zapisano. <ul><li>'
                    . implode('</li><li>', $validate->invalidInfos())
                    . '</li></ul>';
                throw new Exception($message);
            }

            $this->sql = "INSERT INTO `addresses` (
                `firstname`,
                `lastname`,
                `mobile`,
                `email`,
                `address`
            ) VALUES (
                :firstname,
                :lastname,
                :mobile,
                :email,
                :address
            )";

            foreach (ModelsAddress::getDataColumns() as $column => $name) {
                if (isset($_POST[$column])) {
                    $this->params[$column] = $_POST[$column];
                }
            }

            Database::instance()
                ->query($this->sql, $this->params);

            $this->message = [
                'text' => 'Dane zapisano pomyślnie!',
                'type' => 'alert-info',
            ];
        } catch (Exception $e) {
            $this->message = [
                'text' => $e->getMessage(),
                'type' => 'alert-danger',
            ];
        }

        $this->responseMessage();
    }

    public function edit(): void
    {
        try {
            $validate = (new Validate(ModelsAddress::class))
                ->parse();

            if (!$validate->valid()) {
                $message = 'Nie zapisano. <ul><li>'
                    . implode('</li><li>', $validate->invalidInfos())
                    . '</li></ul>';
                throw new Exception($message);
            }

            $this->sql = "UPDATE `addresses`
                SET
                    `firstname` = :firstname,
                    `lastname` = :lastname,
                    `mobile` = :mobile,
                    `email` = :email,
                    `address` = :address
                WHERE id = :id";

            $this->params['id'] = (int) $_POST['id'];
            foreach (ModelsAddress::getDataColumns() as $column => $name) {
                if (isset($_POST[$column])) {
                    $this->params[$column] = $_POST[$column];
                }
            }

            Database::instance()
                ->query($this->sql, $this->params);

            $this->message = [
                'text' => 'Dane zapisano pomyślnie!',
                'type' => 'alert-info',
            ];
        } catch (Exception $e) {
            $this->message = [
                'text' => $e->getMessage(),
                'type' => 'alert-danger',
            ];
        }

        $this->responseMessage();
    }

    public function delete(): void
    {
        $this->sql = "DELETE FROM `addresses` WHERE `id` = :id";
        $this->params['id'] = (int) $_POST['id'];

        try {
            Database::instance()
                ->query($this->sql, $this->params);

            $this->message = [
                'text' => 'Dane usunięto pomyślnie!',
                'type' => 'alert-info',
            ];
        } catch (Exception $e) {
            $this->message = [
                'text' => $e->getMessage(),
                'type' => 'alert-danger',
            ];
        }

        $this->responseMessage();
    }

    private function responseMessage()
    {
        if (count($this->message)) {
            $_SESSION['message'] = [
                'text' => $this->message['text'],
                'type' => $this->message['type'],
            ];

            header('Location: ' . $this->reloadLocation);
            exit;
        }
    }
}
