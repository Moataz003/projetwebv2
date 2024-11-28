<?php
// Include the task controller and model
include_once __DIR__ . '/../../Controller/task_con.php';
include_once __DIR__ . '/../../Model/task.php';

// Create an instance of the task controller
$taskC = new TaskController('task');

// Create an empty task variable
$task = null;

if (isset($_GET['id'])) {
    // Task ID exists, so we are in "update" mode
    $current_id = $_GET['id'];
    $current_type = $_GET['type'];
    $current_course_id = $_GET['course_id'];
    $task = $taskC->getTask($current_id);  // Fetch the existing task from the database
}

// Check if the form is submitted
if (
    isset($_POST["course_id"]) &&
    isset($_POST["task_name"]) &&
    isset($_POST["task_description"])
) {
    // Validate that no field is empty
    if (
        !empty($_POST["course_id"]) &&
        !empty($_POST["task_name"]) &&
        !empty($_POST["task_description"])
    ) {
        // Set course_id and quiz_id to null if not provided
        $course_id = !empty($_POST['course_id']) ? $_POST['course_id'] : null;

        // If updating, preserve the original task order (if needed)
        if ($task) {
            $task_order = $task['task_order'];  // If it's an update, keep the original task order
        } else {
            // If new task, generate the task order
            $task_order = $taskC->countTasksInCourse($_POST['course_id']) + 1;
        }

        // Create a new Task object with the updated data
        $task = new Task(
            $current_id ?? null,  // If we are updating, pass the current task ID, else null for a new task
            $_POST['task_name'],
            $_POST['task_description'],
            $course_id,
            $task_order,
            0
        );

        // Add the task to the database (update if ID exists)
        if ($task->get_task_id()) {
            // Update the task if it's an existing task
            $taskC->updateTask($task, $current_id);

        } else {
            $error_message = "Task ID not found!";
            header('Location: ../../view/Back/tasks_management.php?course-filter=' . $current_course_id);
            exit();
        }

        // Success message and redirect
        $success_message = "Task " . ($task->get_task_id() ? "updated" : "added") . " successfully!";
        header('Location: ../../view/Back/tasks_management.php?course-filter=' . $current_course_id);
        exit();
    } else {
        // Error handling if any field is empty
        $error_message = "All fields are required.";
        header('Location: ../../view/Back/tasks_management.php?course-filter=' . $current_course_id);
        exit();
    }
}
?>
