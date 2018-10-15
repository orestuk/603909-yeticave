<?php

require_once('functions.php');
require_once('services/services.php');

$services = new Services();
$categories = $services->get_categories();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;

    $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $is_int = ['lot-rate', 'lot-step'];
    $dict = ['lot-name' => 'Наименование',
        'category' => 'Категория',
        'message' => 'Описание',
        'lot-rate' => 'Начальная цена',
        'lot-step' => 'Шаг ставки',
        'lot-date' => 'Дата окончания торгов'
    ];
    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    foreach ($is_int as $key) {
        if (is_int($_POST[$key])) {
            $errors[$key] = 'Это поле должно содержать только цыфры';
        }
    }

    if (isset($_FILES['lot-image']['name']) and !empty($_FILES['lot-image']['name'])) {
        $tmp_name = $_FILES['lot-image']['tmp_name'];
        $path = $_FILES['lot-image']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg") {
            $errors['lot-image'] = 'Загрузите картинку в формате JPG';
        } else {
            move_uploaded_file($tmp_name, 'img/' . $path);
            $lot['image_url'] = $path;
        }

    } else {
        $errors['lot-image'] = 'Вы не загрузили файл';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', ['lot' => $lot, 'errors' => $errors, 'categories' => $categories]);
    } else {
        $page_content = include_template('view.php', ['gif' => $gif]);
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
    'is_auth' => $services->is_auth
]);

print($layout_content);
