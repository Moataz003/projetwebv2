<?php
include_once __DIR__ . '/../../Controller/task_con.php';

// Création d'une instance du contrôleur des événements
$taskC = new TaskController('task');

if (isset($_GET['id']) && isset($_GET['type']) && isset($_GET['course_id'])) {
    $current_id = $_GET['id']; 
    $current_type = $_GET['type'];
    $current_course_id = $_GET['course_id'];

    $res = $taskC->deleteTask($current_id);

    if ($res){
        if ($current_type == 'course') {
            header('Location: ../../view/Back/tasks_management.php?course-filter=' . $current_course_id);
            exit();
        } else {
            header('Location: ../../view/Back/tasks_management.php');
            exit();
        }
    }
    else{
        if ($current_type == 'course') {
           header('Location: ../../view/Back/tasks_management.php?course-filter=' . $current_course_id);
            exit();
        } else {
            header('Location: .../../view/Back/tasks_management.php');
            exit();
        }
    }
}
else{
    header('Location: ../../view/Back/tasks_management.php');
    exit();
}


?>  