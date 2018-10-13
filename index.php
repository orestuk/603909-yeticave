<?php

require_once('functions.php');
require_once('data.php');
require_once('init.php');

$lots = [];
$categories = [];

if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
} else {
    $sql = 'SELECT lt.name, lt.price, lt.image_url AS url, ct.name AS category
                FROM lots AS lt
                    INNER JOIN categories AS ct ON ct.id = lt.category_id
                WHERE lt.date_completion > current_date()
                ORDER BY  lt.id DESC
                LIMIT 10';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
    }
}

if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
} else {
    $sql = 'SELECT * FROM categories;';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
    }
}


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
