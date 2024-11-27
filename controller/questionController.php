<?php
require_once '../model/Question.php';

// Assuming you are passing quizId to get questions
if (isset($_GET['quizId'])) {
    $quizId = $_GET['quizId'];
    $questions = Question::getQuestionsByQuiz($quizId);

    // Now $questions contains all the questions related to that quiz
    // Pass $questions to your view
}
