<?php

require_once('functions.php');
require_once('services/services.php');
$config = require_once 'config/config.php';

$services = new Services();
$categories = $services->get_categories();

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST;

    $required = ['email', 'password'];
    $dict = [
        'email' => 'адрес электронной почты',
        'password' => 'пароль',
    ];
    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Заполните пожалуйста ' . $dict[$key];
        }
    }

    if (count($errors)) {
        $page_content = include_template('login.php', ['user' => $user, 'errors' => $errors, 'categories' => $categories]);
    } else {
        $account = $services->get_user_by_email($user['email']);

        if ($account) {

            if (password_verify($user['password'], $account[0]['password'])) {
                $_SESSION['user'] = $account[0];
            } else {
                $errors['password'] = 'Неверный пароль';
            }
        } else {
            $errors['email'] = 'Такой пользователь не найден';
        }
        if (count($errors)) {
            $page_content = include_template('login.php', ['user' => $user, 'errors' => $errors, 'categories' => $categories]);
        }
        else {
            header("Location: /index.php");
            exit();
        }
    }
}
else {
    if (isset($_SESSION['user'])) {
        header("Location: /index.php");
        exit();
    }
    else {
        $page_content = include_template('login.php', ['categories' => $categories]);
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная страница',
    'username' => isset($_SESSION["user"]) ? $_SESSION["user"]['name'] : ''
]);

print($layout_content);

