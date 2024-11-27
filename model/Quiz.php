<?php
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/ahhhhh/config');
require_once('config.php');


class Quiz {
    private $id;
    private $title;

    public function __construct($id = null, $title = null) {
        $this->id = $id;
        $this->title = $title;
    }

    public static function getQuizById($quizId) {
        $db = config::getConnexion();
        $stmt = $db->prepare("SELECT * FROM quiz WHERE id_quiz = :quizId");
        $stmt->bindParam(':quizId', $quizId);
        $stmt->execute();
        return $stmt->fetch(); // Returns the quiz as an associative array
    }

    public function getAllQuizzes() {
        $db = config::getConnexion();
        $stmt = $db->prepare("SELECT * FROM quiz");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function save() {
        $db = config::getConnexion();
        $stmt = $db->prepare("INSERT INTO quiz (titre_quiz) VALUES (:title)");
        $stmt->bindParam(':title', $this->title);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function deleteQuizById($quizId) {
        $db = config::getConnexion();
        $stmt = $db->prepare("DELETE FROM quiz WHERE id_quiz = :quizId");
        $stmt->bindParam(':quizId', $quizId);
        $stmt->execute();
    }

    public function update() {
        $db = config::getConnexion();
        $stmt = $db->prepare("UPDATE quiz SET titre_quiz = :title WHERE id_quiz = :id");
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }
}
