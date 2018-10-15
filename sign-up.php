<?php

require_once('functions.php');
require_once('services/services.php');
$config = require_once 'config/config.php';

$services = new Services();
$categories = $services->get_categories();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST;

    $required = ['email', 'password', 'name', 'message'];
    $dict = ['lot-name' => 'Наименование',
        'email' => 'адрес электронной почты',
        'message' => 'контактные данные',
        'password' => 'пароль',
        'name' => 'имя пользователя'
    ];
    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Заполните пожалуйста ' . $dict[$key];
        }
    }

    if (!empty($user['email'])){
        if  (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введите коректый адрес электронной почты';
        } else {
            $id = $services->get_user_by_email($user['email']);
            if (count($id)) {
                $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
            }
        }
    }

    $path = '';
    $tmp_name = '';
    if (isset($_FILES['avatar']['name']) and !empty($_FILES['avatar']['name'])) {
        $tmp_name = $_FILES['avatar']['tmp_name'];
        $path = $_FILES['avatar']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/jpeg") {
            $errors['avatar'] = 'Загрузите картинку в формате JPG';
        }
    }

    if (count($errors)) {
        $page_content = include_template('sign-up.php', ['user' => $user, 'errors' => $errors, 'categories' => $categories]);
    } else {
        if ($path) {
            move_uploaded_file($tmp_name, $config['avatar_image_directory'] . $path);
            $user['avatar'] = $path;
        }

        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

        $res = $services->add_user($user);

        if ($res) {
            header("Location: login.php");
            exit();
        }
    }
}
else {
    $page_content = include_template('sign-up.php', [
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
