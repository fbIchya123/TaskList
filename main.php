<?php
session_start();
include 'connect_db.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Task Manager</title>
    </head>
    <body>
        <form action="exit.php">
            <button type="submit">Exit</button>
        </form>
        <h1>
            <?php
            echo $_SESSION['user_name'];
            ?>
        </h1>

        <!--Блок с полем ввода описания таска и кнопками 'Dell ALL' и 'READY ALL'-->
        <div class="block1">
            <form action="general_script_task.php" method="post" class="form_auth">
                <div class="add_task">
                    <input type="text" placeholder="Task description" name="description">
                    <input type="submit" value="Add Task" name="add_task">
                </div>
                <div>
                    <button type="submit" value="Remove All" name="remove_all">Del All</button>
                    <button type="submit" value="Ready All" name="ready_all">Ready All</button>
                </div>
            </form>
        </div>

        <!--Блок с тасками-->
        <div class="block2">
                <?php

                //Запрос на вывод всех тасков пользователя
                $query = $pdo->prepare("SELECT id, description, status FROM tasks WHERE user_id = :user_id");
                $query->execute([':user_id' => $_SESSION['user_id']]);
                
                //Вывод тасков
                while ($task = $query->fetch(PDO::FETCH_LAZY)){
                    
                    //Цветовой индикатор статуса
                    switch ($task->status){
                        case "READY":
                            $color = 'red';
                            break;
                        case "UNREADY":
                            $color = 'blue';
                            break;
                    }

                    echo '<form action="individual_script_task.php" method="post" style="border-left: 2px solid ' . $color . '; padding: 4px;">';
                    echo '<p style="width: 180px;">' . $task->description . '</p><br>';
                    echo '<div class="task_buttons">';
                    echo '<button name="status" value="' . $task->id . '">' . $task->status . '</button>';
                    echo '<button name="delete" value="' . $task->id . '">Delete</button>';
                    echo '</div>';
                    echo '</form><br>';
                }  
                ?>   
        </div>
    </body>
</html>