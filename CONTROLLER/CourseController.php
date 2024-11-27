<?php
require_once './config.php';
require_once './MODEL/Course.php';
require_once './MODEL/Category.php';

class CourseController {
    public function addCourse(Course $course)
    {
        $sql = "INSERT INTO course (id_form, nom_form, description, category_id) 
                VALUES (:id_form, :nom_form, :description, :category_id)";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_form' => $course->getIdForm(),
                'nom_form' => $course->getNomForm(),
                'description' => $course->getDescription(),
                'category_id' => $course->getCategoryId(), // Using category ID
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
