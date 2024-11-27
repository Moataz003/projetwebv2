<?php
require_once '../model/Quiz.php';
require_once '../model/Question.php';

// Handle quiz creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    $quizTitle = $_POST['quiz_title'];
    $questions = $_POST['questions'];  // This will be an array of questions

    // Create a new quiz object
    $quiz = new Quiz(null, $quizTitle);
    $quizId = $quiz->save();  // Save the quiz and retrieve its ID

    // Now add the questions for the newly created quiz
    foreach ($questions as $q) {
        $question = new Question(
            $quizId,
            $q['question'],
            $q['option1'],
            $q['option2'],
            $q['option3'],
            $q['response']
        );
        $question->save();  // Save each question
    }

    // Redirect to listQuiz.php with a success message
    header('Location: ../view/listQuiz.php?message=Quiz+added+successfully');
    exit();
}

// Handle quiz deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_quiz'])) {
    if (isset($_POST['quiz_id']) && !empty($_POST['quiz_id'])) {
        $quizId = intval($_POST['quiz_id']); // Ensure it is an integer

        // First, delete all associated questions
        Question::deleteQuestionsByQuiz($quizId);

        // Then, delete the quiz itself
        Quiz::deleteQuizById($quizId);

        // Redirect back to deleteQuiz.php with a success message
        header('Location: ../view/deleteQuiz.php?message=Quiz+deleted+successfully');
        exit();
    } else {
        // Redirect back with an error message if quiz_id is invalid
        header('Location: ../view/deleteQuiz.php?message=Invalid+quiz+ID');
        exit();
    }
}

// Handle quiz update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quiz'])) {
    $quizId = $_POST['quiz_id']; // Get quiz ID
    $quizTitle = $_POST['quiz_title']; // Get new quiz title
    $questions = $_POST['questions'];  // Get updated questions array

    // Update the quiz title
    $quiz = new Quiz($quizId, $quizTitle);
    $quiz->update(); // Update quiz title in the database

    // Update questions
    foreach ($questions as $questionId => $q) {
        $question = new Question(
            $quizId,
            $q['question'],
            $q['option1'],
            $q['option2'],
            $q['option3'],
            $q['response'],
            $questionId
        );
        $question->update(); // Update each question in the database
    }

    // Redirect to listQuiz.php with a success message
    header('Location: ../view/listQuiz.php?message=Quiz+updated+successfully');
    exit();
}

// Fetch all quizzes to display in listQuiz.php
$quizModel = new Quiz();
$quizzes = $quizModel->getAllQuizzes();  // Get all quizzes from the database

// Include the listQuiz view to display the quizzes
require_once '../view/listQuiz.php';
