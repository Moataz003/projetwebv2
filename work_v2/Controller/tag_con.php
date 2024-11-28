<?php

require_once __DIR__ . '/../config.php';

class TagController
{
    private $tab_name;

    public function __construct($tab_name)
    {
        $this->tab_name = $tab_name;
    }

    // Create a new tag
    public function addTag($tagName)
    {
        $sql = "INSERT INTO $this->tab_name (tag_name) VALUES (:tag_name)";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(['tag_name' => $tagName]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error adding tag: " . $e->getMessage());
        }
    }

    // List all tags
    public function listTags()
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

    // Get a specific tag by ID
    public function getTag($id)
    {
        $sql = "SELECT * FROM $this->tab_name WHERE tag_id = :id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            $tag = $query->fetch();
            return $tag;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Update a tag's name
    public function updateTag($tagId, $tagName)
    {
        $sql = "UPDATE $this->tab_name SET tag_name = :tag_name WHERE tag_id = :tag_id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(['tag_id' => $tagId, 'tag_name' => $tagName]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error updating tag: " . $e->getMessage());
        }
    }

    // Delete a tag
    public function deleteTag($tagId)
    {
        $sql = "DELETE FROM $this->tab_name WHERE tag_id = :tag_id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(['tag_id' => $tagId]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error deleting tag: " . $e->getMessage());
        }
    }

    public function getTagByName($tagName) {
        $sql = "SELECT * FROM $this->tab_name WHERE tag_name = :tag_name";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(['tag_name' => $tagName]);
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
