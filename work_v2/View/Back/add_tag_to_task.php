<?php
include_once __DIR__ . '/../../Controller/task_tag_con.php';

header('Content-Type: application/json');

try {
    if (isset($_POST['task_id']) && isset($_POST['tag_id'])) {
        $taskTagC = new TaskTagController('task_tag');
        
        // Convert to integers to ensure proper data type
        $taskId = intval($_POST['task_id']);
        $tagId = intval($_POST['tag_id']);
        
        // Add the tag
        $taskTagC->addTagToTask($taskId, $tagId);
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Tag added successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Missing task_id or tag_id'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
exit;
 