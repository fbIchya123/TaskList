<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
include_once 'connect_db.php';

$user_id = $_SESSION['user_id'];

if (isset($user_id)){
    
    //Удаление таска
    if (!empty($_POST['delete'])){
        $query = $pdo->prepare("DELETE FROM `tasks` WHERE id = :id AND user_id = :user_id");
        $query->execute([':id' => $_POST['delete'], ':user_id' => $user_id]);

    //Изменение статуса таска
    } else if (!empty($_POST['status'])){

        //Запрос на получение статуса таска
        $query = $pdo->prepare("SELECT status FROM `tasks` WHERE id = :id AND user_id = :user_id");
        $query->execute([':id' => $_POST['status'], ':user_id' => $user_id]);
        $status = $query->fetch(PDO::FETCH_LAZY)->status;

        //Изменение значения статуса
        switch ($status){
            case "READY":
                $status = "UNREADY";
                break;
            case "UNREADY":
                $status = "READY";
                break;
        }

        //Занесение значения статуса в бд
        $query = $pdo->prepare("UPDATE `tasks` SET status = :status WHERE id = :id");
        $query->execute([':id' => $_POST['status'], ':status' => $status]);
    }

    header("Location: main.php");

} else {
    header("Location: ./");

}


