<?php
require_once dirname(__DIR__) . '/init.php';

session_start();

if (isset($_POST['model'])) {
    $class = 'Actions\\' . $_POST['model'];
    $action = $_POST['action'] ?: null;

    if (class_exists($class)) {
        (new $class())->$action();
    }
}

// Prepare messege
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

$params = [];

// Extend SQL while search is used
$searchSql = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    $searchSql = " WHERE
        (`firstname` LIKE :search
        OR `lastname` LIKE :search
        OR `mobile` LIKE :search
        OR `email` LIKE :search
        OR `address` LIKE :search)";

    if (empty($search)) {
        $searchSql .= " AND `id` = 0";
    }

    $params['search'] = '%' . htmlentities($search, ENT_QUOTES, 'UTF-8') . '%';
}

// Count all rows
$result = $db->query("SELECT COUNT(*) AS `total`
        FROM `addresses` {$searchSql}", $params)
    ->fetch();

$total = (int) $result[0]['total'];

// Fetch limited results
$perPage = 10;
$pages = ceil($total / $perPage);
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = $perPage * ($page - 1);
$limit = $perPage;

$params['limit'] = $limit;
$params['offset'] = $offset;

$results = $db->query("SELECT *
        FROM `addresses`
        {$searchSql}
        LIMIT :limit OFFSET :offset", $params)
    ->fetch();

$lp = $offset + 1;

// Display list
include VIEWS_DIR . '/list.php';
