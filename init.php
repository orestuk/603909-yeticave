<?php

$db = require_once 'config/db.php';

set_time_limit(0);

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");
