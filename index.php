<?php

require_once('functions.php');
require_once('services/services.php');

session_start();

$services = new Services();
$lots = $services->get_lots();
$categories = $services->get_categories();

$page_content = include_template('index.php', [
   'lots' => $lots,
   'categories' => $categories
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная страница',
    'username' => isset($_SESSION["user"]) ? $_SESSION["user"]['name'] : ''
]);

print($layout_content);
