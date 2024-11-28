<?php
require_once __DIR__ . '/../config.php';

class CourseController
{

    private $tab_name;

    public function __construct($tab_name) {
        $this->tab_name = $tab_name;
    }


    public function listCourses() {
        $sql = "SELECT * FROM $this->tab_name";
    
        $db = config::getConnexion();
        try {
            $stmt = $db->query($sql);  // Get PDOStatement object
            $liste = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch results as an associative array
            return $liste;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];  // Return an empty array if there's an error
        }
    }
    
}
