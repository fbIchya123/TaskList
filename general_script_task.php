<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
include 'connect_db.php';

$user_id = $_SESSION['user_id'];
$description = $_POST['description'];
$created_at = date("Y-m-d");

//Проверка авторизации
if(isset($user_id)){

    //Добавление новой задачи в базу
    if (!empty($_POST['add_task'])){
        $query = $pdo->prepare("INSERT INTO `tasks` (user_id, description, created_at, status) VALUES (:user_id, :description, :created_at, 'READY')"); 
        $query->execute([':user_id' => $user_id, ':description' => $description, ':created_at' => $created_at]);

    //Удаление всех задач
    } else if (!empty($_POST['remove_all'])){
        $query = $pdo->prepare("DELETE FROM `tasks` WHERE user_id = :user_id");
        $query->execute([':user_id' => $user_id]);

    //Смена статуса всех задач на READY    
    } else {
        $query = $pdo->prepare("UPDATE `tasks` SET status = :status WHERE user_id = :user_id");
        $query->execute(['status' => 'UNREADY', ':user_id' => $user_id]);
    }
    header("Location: main.php");

//Переход на страницу регистрации/авторизации
} else {
    header("Location: ./");

}






