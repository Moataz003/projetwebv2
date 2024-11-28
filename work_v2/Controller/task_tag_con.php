<?php
include_once __DIR__ . '/../config.php';

class TaskTagController
{
    private $tab_name;

    public function __construct($tab_name)
    {
        $this->tab_name = $tab_name;
    }

    // Add a tag to a task
    public function addTagToTask($task_id, $tag_id)
    {
        $sql = "INSERT INTO $this->tab_name (task_id, tag_id) VALUES (:task_id, :tag_id)";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(
                [
                    'task_id' => $task_id,
                    'tag_id' => $tag_id
                ]
            );
            
            if ($query->rowCount() === 0) {
                throw new Exception("Failed to add tag to task");
            }
            
            return true;
        } catch (PDOException $e) {
            // Check if it's a duplicate entry error
            if ($e->getCode() == 23000) {
                throw new Exception("This tag is already assigned to the task");
            }
            throw new Exception("Error adding tag: " . $e->getMessage());
        }
    }

    // Remove a tag from a task
    public function removeTagFromTask($task_id, $tag_id)
    {
        $sql = "DELETE FROM $this->tab_name WHERE task_id = :task_id AND tag_id = :tag_id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(
                [
                    'task_id' => $task_id,
                    'tag_id' => $tag_id
                ]
            );
            return true;
        } catch (Exception $e) {
            throw new Exception("Error removing tag: " . $e->getMessage());
        }
    }

    // List all tags for a given task
    public function getTagsForTask($task_id)
    {
        $sql = "SELECT t.* FROM tags t 
                JOIN $this->tab_name tt ON t.tag_id = tt.tag_id
                WHERE tt.task_id = :task_id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(['task_id' => $task_id]);
            $tags = $query->fetchAll();
            return $tags;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Get all task-tag associations
    public function listTaskTags()
    {
        $sql = "SELECT * FROM $this->tab_name";
        $db = config::getConnexion();

        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function getTagsByTaskId($task_id) {
        $sql = "SELECT tag_id FROM $this->tab_name WHERE task_id = :task_id";
        $db = config::getConnexion();
        
        try {
            $query = $db->prepare($sql);
            $query->execute(['task_id' => $task_id]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching tags: " . $e->getMessage());
        }
    }
}
?>
