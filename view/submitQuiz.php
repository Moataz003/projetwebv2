<?php
require_once '../model/Quiz.php';
require_once '../model/Question.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure quizId, answers, and question_ids are set
    if (isset($_POST['quizId'], $_POST['answers'])) {
        $quizId = $_POST['quizId'];
        $answers = $_POST['answers'];  // User's selected answers (array of option texts)

        // Fetch the correct answers from the database
        $correctAnswers = [];
        $questions = Question::getQuestionsByQuiz($quizId);

        // Store the correct answers in an array
        foreach ($questions as $question) {
            // Correct answer stored in 'reponse' column (the correct option text)
            $correctAnswers[$question['id_question']] = $question['reponse'];
        }

        // Calculate the score
        $score = 0;
        foreach ($answers as $questionId => $selectedAnswer) {
            // Check if the selected answer matches the correct answer text
            if (isset($correctAnswers[$questionId]) && $selectedAnswer == $correctAnswers[$questionId]) {
                $score++;  // Increment score if answer is correct
            }
        }

        // Display the result
        echo "<h1>Quiz Completed</h1>";
        echo "<p>Your score: $score / " . count($questions) . "</p>";
    } else {
        echo "Some data is missing. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
