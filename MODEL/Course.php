<?php

require_once './MODEL/Category.php';

// Course Model (Corrected)
class Course {
    private string $idForm;
    private string $nomForm;
    private string $description;
    private int $categoryId; // This should be an integer ID representing the category.

    // Constructor
    public function __construct(string $idForm, string $nomForm, string $description, int $categoryId) {
        $this->idForm = $idForm;
        $this->nomForm = $nomForm;
        $this->description = $description;
        $this->categoryId = $categoryId;
    }

    // Getters and Setters
    public function getIdForm(): string {
        return $this->idForm;
    }

    public function getNomForm(): string {
        return $this->nomForm;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getCategoryId(): int {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): void {
        $this->categoryId = $categoryId;
    }

    // ... other getters and setters
}
