<?php
require_once('functions.php');
require_once('data.php');

$page_content = include_template("index.php", [
   'lots' => $lots,
   'categories' => $categories
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная страница',
    'is_auth' => $is_auth
]);

print($layout_content);
