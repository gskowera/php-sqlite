<?php

require_once dirname(dirname(__DIR__)) . '/init.php';

$row = [];

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    $result = $db->query("SELECT *
            FROM `addresses`
            WHERE `id` = :id", [
            'id' => $id,
        ])
        ->fetch();

    if (count($result)) {
        $row = $result[0];
    }
}

print json_encode($row);
