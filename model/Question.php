<?php
require_once '../config/config.php';

class Question {
    private $id;
    private $quizId;
    private $question;
    private $option1;
    private $option2;
    private $option3;
    private $response;

    public function __construct($quizId = null, $question = null, $option1 = null, $option2 = null, $option3 = null, $response = null, $id = null) {
        $this->id = $id;
        $this->quizId = $quizId;
        $this->question = $question;
        $this->option1 = $option1;
        $this->option2 = $option2;
        $this->option3 = $option3;
        $this->response = $response;
    }

    public static function getQuestionsByQuiz($quizId) {
        $db = config::getConnexion();
        $stmt = $db->prepare("SELECT * FROM question WHERE id_quiz = :quizId");
        $stmt->bindParam(':quizId', $quizId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function save() {
        $db = config::getConnexion();
        $stmt = $db->prepare("INSERT INTO question (id_quiz, question, option1, option2, option3, reponse) 
                              VALUES (:quizId, :question, :option1, :option2, :option3, :response)");
        $stmt->bindParam(':quizId', $this->quizId);
        $stmt->bindParam(':question', $this->question);
        $stmt->bindParam(':option1', $this->option1);
        $stmt->bindParam(':option2', $this->option2);
        $stmt->bindParam(':option3', $this->option3);
        $stmt->bindParam(':response', $this->response);
        $stmt->execute();
    }

    public static function deleteQuestionsByQuiz($quizId) {
        $db = config::getConnexion();
        $stmt = $db->prepare("DELETE FROM question WHERE id_quiz = :quizId");
        $stmt->bindParam(':quizId', $quizId);
        $stmt->execute();
    }

    public function update() {
        $db = config::getConnexion();
        $stmt = $db->prepare("UPDATE question SET question = :question, option1 = :option1, option2 = :option2, option3 = :option3, reponse = :response WHERE id_question = :id");
        $stmt->bindParam(':question', $this->question);
        $stmt->bindParam(':option1', $this->option1);
        $stmt->bindParam(':option2', $this->option2);
        $stmt->bindParam(':option3', $this->option3);
        $stmt->bindParam(':response', $this->response);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public static function getQuestionById($id) {
        $db = config::getConnexion();
        $stmt = $db->prepare("SELECT * FROM question WHERE id_question = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
