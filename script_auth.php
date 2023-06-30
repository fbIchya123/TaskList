<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
include 'connect_db.php';

$login = $_POST['login'];
$password = $_POST['password'];
$created_at = date("Y-m-d");
$redirect = "main.php";


//Запрос на проверку наличия аккаунта
$query = $pdo->prepare("SELECT * FROM users WHERE name = :name AND password = :password"); 
$query->execute([':name' => $login, ':password' => $password]);


//Проверка наличия акка в базе
if ($row = $query->fetch(PDO::FETCH_LAZY)){
    $_SESSION['user_id'] = $row->id;    
    header("Location: " . $redirect);
    
} else {
    //Добавление акка, если его нет
    $query = $pdo->prepare("INSERT INTO `users` (name, password, created_at) VALUES (:name, :password, :created_at)"); 
    $query->execute([':name' => $login, ':password' => $password, ':created_at' => $created_at]);
    header("Location: " . $redirect);
}

