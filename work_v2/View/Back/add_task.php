<?php
// Include necessary controllers and models
include_once __DIR__ . '/../../Controller/task_con.php';
include_once __DIR__ . '/../../Controller/task_tag_con.php';
include_once __DIR__ . '/../../Model/task.php';
include_once __DIR__ . '/../config.php';

// Create instances of controllers
$taskC = new TaskController('task');
$taskTagC = new TaskTagController('task_tag');

// Create an empty task variable
$task = null;

// Check if the form is submitted
if (
    isset($_POST["course_id"]) &&
    isset($_POST["task_name"]) &&
    isset($_POST["task_description"])
) {
    // Validate that required fields are not empty
    if (
        !empty($_POST["course_id"]) &&
        !empty($_POST["task_name"]) &&
        !empty($_POST["task_description"])
    ) {
        try {
            $db = config::getConnexion();
            $db->beginTransaction(); // Start transaction

            // Create new Task object
            $course_id = !empty($_POST['course_id']) ? $_POST['course_id'] : null;
            $task_order = $taskC->countTasksInCourse($_POST['course_id']) + 1;

            $task = new Task(
                null,
                $_POST['task_name'],
                $_POST['task_description'],
                $course_id,
                $task_order,
                0
            );

            // Add the task
            $taskC->addTask($task);
            $task_id = $db->lastInsertId();

            // Handle tags if present
            if (isset($_POST['selected_tag_ids']) && !empty($_POST['selected_tag_ids'])) {
                $tagIds = json_decode($_POST['selected_tag_ids'], true);
                
                if (is_array($tagIds)) {
                    foreach ($tagIds as $tag_id) {
                        $taskTagC->addTagToTask($task_id, $tag_id);
                    }
                }
            }

            $db->commit(); // Commit transaction
            
            // Redirect back to tasks management page
            header('Location: tasks_management.php?course-filter=' . urlencode($course_id));
            exit();

        } catch (Exception $e) {
            $db->rollBack(); // Rollback on error
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "All fields are required.";
    }
}

// If we get here, something went wrong
header('Location: tasks_management.php');
exit();
?>
