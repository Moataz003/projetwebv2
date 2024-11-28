<?php
include_once __DIR__ . '/../../Controller/tag_con.php';

if (isset($_POST['tag_name'])) {
    $tagC = new TagController('tag');
    try {
        $tagC->addTag($_POST['tag_name']);
        header('Location: tags_management.php');
    } catch (Exception $e) {
        echo "Error adding tag: " . $e->getMessage();
    }
} else {
    echo "Tag name is required.";
}
exit; 