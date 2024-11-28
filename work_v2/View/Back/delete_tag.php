<?php
include_once __DIR__ . '/../../Controller/tag_con.php';

if (isset($_GET['id'])) {
    $tagC = new TagController('tag');
    try {
        $tagC->deleteTag($_GET['id']);
        header('Location: tags_management.php');
    } catch (Exception $e) {
        echo "Error deleting tag: " . $e->getMessage();
    }
} else {
    echo "Tag ID is required.";
}
exit; 