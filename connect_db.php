<?php
define('HOST', 'localhost');
define('DB_NAME', 'tasklist');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

try{
    $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DB_NAME . '', DB_USER, DB_PASSWORD);
} catch (PDOException $e) {
    echo $e->getMessage();
    die;
}

?>