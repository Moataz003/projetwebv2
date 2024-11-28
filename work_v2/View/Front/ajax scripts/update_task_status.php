<?php
error_reporting(0);
include_once __DIR__ . '/../../../Controller/task_con.php';
include_once __DIR__ . '/../../../Model/Task.php';

$taskId = intval($_POST['task_id']);
$status = intval($_POST['status']);

if ($taskId <= 0 || ($status !== 0 && $status !== 1)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid task_id or status.']);
    return;
} else {
    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $taskC = new TaskController('task');

            $res = $taskC->updateTaskStatus( $status, $taskId);
            if ($res) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Task status updated successfully.']);
                return;
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Task not found.']);
                return;
            }

        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            return;
        }
        
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'An error occurred.']);
        return;
    }
}




?>