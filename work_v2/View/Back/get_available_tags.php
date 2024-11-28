<?php
include_once __DIR__ . '/../../Controller/tag_con.php';
include_once __DIR__ . '/../../Controller/task_tag_con.php';

header('Content-Type: application/json');

if (isset($_GET['task_id'])) {
    $tagC = new TagController('tag');
    $taskTagC = new TaskTagController('task_tag');
    
    try {
        // Get all tags
        $allTags = $tagC->listTags()->fetchAll(PDO::FETCH_ASSOC);
        // Get tags already associated with the task
        $taskTags = $taskTagC->getTagsByTaskId($_GET['task_id']);
        
        // Get IDs of tags already associated with the task
        $taskTagIds = array_column($taskTags, 'tag_id');
        
        // Filter out tags that are already associated with the task
        $availableTags = array_filter($allTags, function($tag) use ($taskTagIds) {
            return !in_array($tag['tag_id'], $taskTagIds);
        });
        
        // Reset array keys and encode as JSON
        echo json_encode([
            'success' => true, 
            'tags' => array_values($availableTags)
        ]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing task ID']);
}
exit; 