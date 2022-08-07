<?php
define('DB_USER', 'guest');
define('DB_PASSWORD', 'guest');
define('DB_HOST', '18.117.14.33');
define('DB_NAME', 'test');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR
    die('Could not connect to MySQL: ' . mysqli_connect_error());

mysqli_set_charset($dbc, 'utf8');