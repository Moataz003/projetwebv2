<?php
require_once './config.php';
require_once './MODEL/Category.php';

class CategoryController
{
    public function addCategory($category)
    {
        $sql = "INSERT INTO category (name, description) VALUES (:name, :description)";
        $db = config::getConnexion(); // Use the correct syntax for calling your database connection

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'name' => $category->getName(),        // Use $category to access the name
                'description' => $category->getDescription(), // Use $category to access the description
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage(); // Corrected error message syntax
        }
    }
}
