<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
include 'connect_db.php';

$login = $_POST['login'];
$password = $_POST['password'];
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
$created_at = date("Y-m-d");

//Функция, возвращающая выборку данных аккаунта по заданному логину
function make_row(){
    global $pdo, $login;
    $query_check_reg_user = $pdo->prepare("SELECT * FROM `users` WHERE name = :name"); 
    $query_check_reg_user->execute([':name' => $login]);
    return $query_check_reg_user->fetch(PDO::FETCH_LAZY);
}

//Запрос на проверку наличия аккаунта
$row = make_row();

//Проверка наличия акка в базе
if ($row){

    //Проверка совпадения паролей
    if (password_verify($password, $row->password)){
        $_SESSION['user_id'] = $row->id;
        $_SESSION['user_name'] = $row->name;
        header("Location: main.php");
        
    } else {
        header("Location: ./");
    }
} else {

    //Добавление акка, если его нет
    $query_add_user = $pdo->prepare("INSERT INTO `users` (name, password, created_at) VALUES (:name, :password, :created_at)"); 
    $query_add_user->execute([':name' => $login, ':password' => $password_hash, ':created_at' => $created_at, ':name' => $login]);

    //Авторизация
    $row = make_row();
    $_SESSION['user_id'] = $row->id;
    $_SESSION['user_name'] = $row->name;
    header("Location: main.php");
}


