<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the Quiz model
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/ahhhhh/model');
require_once('Quiz.php');


// Initialize Quiz model and fetch quizzes
$quizModel = new Quiz();
$quizzes = $quizModel->getAllQuizzes();  // Fetch all quizzes from the database

// Check if there are quizzes to display
if (empty($quizzes)) {
    echo "<p>No quizzes available at the moment.</p>";
} else {
?>
    <h1>Select a Quiz to Take</h1>
    <ul>
        <?php foreach ($quizzes as $quiz): ?>
            <li>
                <a href="../takeQuiz.php?quizId=<?php echo $quiz['id_quiz']; ?>">
                    <?php echo htmlspecialchars($quiz['titre_quiz']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php
}
?>