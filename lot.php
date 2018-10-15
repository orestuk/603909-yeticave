<?php

require_once('functions.php');
require_once('services/services.php');

session_start();

$id = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    redirect_to_error_404('Не задан идентификатор лота');
}

$services = new Services();
$categories = $services->get_categories();
$lots = $services->get_lot($id);

if (!count($lots))
{
    redirect_to_error_404('Лот с этим идентификатором не найден');
}

$page_content = include_template('lot.php', [
    'categories' => $categories,
    'lot' => $lots[0],
    'username' => isset($_SESSION["user"]) ? $_SESSION["user"]['name'] : ''
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная страница',
    'username' => isset($_SESSION["user"]) ? $_SESSION["user"]['name'] : ''
]);

print($layout_content);
