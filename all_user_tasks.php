<?php   

//Запрос на вывод всех тасков пользователя
$query_all_user_tasks = $pdo->prepare("SELECT id, description, status FROM tasks WHERE user_id = :user_id");
$query_all_user_tasks->execute([':user_id' => $_SESSION['user_id']]);
