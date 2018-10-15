<?php

require_once('functions.php');
require_once('services/services.php');

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
    'is_auth' => $services->is_auth
]);

print($layout_content);
