<?php

require_once('functions.php');

$error = '';

session_start();

if (isset($_SESSION['error'])) {
  $error = $_SESSION['error'];
}

$content = include_template('error.php', ['error'=>$error]);

print($content);
