<?php
include_once __DIR__ . '/../../Controller/task_tag_con.php';

if (isset($_GET['task_id']) && isset($_GET['tag_id']) && isset($_GET['course_id'])) {
    $taskTagC = new TaskTagController('task_tag');
    
    try {
        $taskTagC->removeTagFromTask($_GET['task_id'], $_GET['tag_id']);
        header('Location: tasks_management.php?course-filter=' . $_GET['course_id']);
    } catch (Exception $e) {
        echo "Error removing tag: " . $e->getMessage();
    }
} else {
    echo "Missing required parameters";
}
exit; 