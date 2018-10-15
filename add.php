<?php

require_once('functions.php');
require_once('services/services.php');

session_start();

if (!isset($_SESSION["user"]))
{
    http_response_code(404);
    header("Location: /index.php");
    exit();
}

$services = new Services();
$categories = $services->get_categories();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;

    $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $is_int = ['lot-rate', 'lot-step'];
    $dict = ['lot-name' => 'Наименование',
        'category' => 'категорию',
        'message' => 'описание',
        'lot-rate' => 'начальная цену',
        'lot-step' => 'шаг ставки',
        'lot-date' => 'дату окончания торгов'
    ];
    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Заполните пожалуйста '. $dict[$key];
        }
    }

    foreach ($is_int as $key) {
        if (is_int($_POST[$key])) {
            $errors[$key] = 'Это поле должно содержать только цыфры';
        }
    }

    $path = '';
    $tmp_name = '';
    if (isset($_FILES['lot-image']['name']) and !empty($_FILES['lot-image']['name'])) {
        $tmp_name = $_FILES['lot-image']['tmp_name'];
        $path = $_FILES['lot-image']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg") {
            $errors['lot-image'] = 'Загрузите картинку в формате JPG';
        }

    } else {
        $errors['lot-image'] = 'Вы не загрузили файл';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', ['lot' => $lot, 'errors' => $errors, 'categories' => $categories]);
    } else {
        move_uploaded_file($tmp_name, 'img/' . $path);
        $lot['lot-image'] = $path;
        $lot_id = $services->add_lot($lot);
        if ($lot_id) {
            header("Location: lot.php?id=" . $lot_id);
            exit();
        }
        $page_content = include_template('lot.php', ['lot' => $lot]);
    }
}
else {
    $page_content = include_template('add.php', [
        'categories' => $categories,
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная страница',
    'username' => isset($_SESSION["user"]) ? $_SESSION["user"]['name'] : ''
]);

print($layout_content);
