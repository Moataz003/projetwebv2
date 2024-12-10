<?php
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/Project/controller');
require('quizController.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Project/model/Question.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_quiz'])) {
    $idQuiz = $_GET['id_quiz'];
    $quiz = Quiz::getQuizById($idQuiz); // Fetch quiz details
    $questions = Question::getQuestionsByQuiz($idQuiz); // Fetch related questions
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_quiz'])) {
    $idQuiz = $_POST['id_quiz'];
    $title = $_POST['title'];

    // Update the quiz title
    Quiz::updateTitle($idQuiz, $title);

    // Update each question
    foreach ($_POST['questions'] as $idQuestion => $questionData) {
        Question::updateQuestion($idQuestion, $questionData['text'], $questionData['option1'], $questionData['option2'], $questionData['option3'], $questionData['answer']);
    }

    // Redirect back to the quizzes list
    echo('<script>document.location.href="\listQuiz.php\"</script>');
    

    




    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Quiz</title>
</head>
<body>
    <h1>Update Quiz</h1>
    <form action="updateQuiz.php" method="POST">
        <input type="hidden" name="id_quiz" value="<?php echo htmlspecialchars($quiz['id_quiz']); ?>">
        
        <label for="title">Quiz Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($quiz['titre_quiz']); ?>" required>
        
        <h3>Questions</h3>
        <ul>
            <?php foreach ($questions as $question): ?>
                <li>
                    <label>Question Text:</label>
                    <input type="text" name="questions[<?php echo $question['id_question']; ?>][text]" value="<?php echo htmlspecialchars($question['question']); ?>" required>
                    
                    <label>Option 1:</label>
                    <input type="text" name="questions[<?php echo $question['id_question']; ?>][option1]" value="<?php echo htmlspecialchars($question['option1']); ?>" required>
                    
                    <label>Option 2:</label>
                    <input type="text" name="questions[<?php echo $question['id_question']; ?>][option2]" value="<?php echo htmlspecialchars($question['option2']); ?>" required>
                    
                    <label>Option 3:</label>
                    <input type="text" name="questions[<?php echo $question['id_question']; ?>][option3]" value="<?php echo htmlspecialchars($question['option3']); ?>" required>
                    
                    <label>Correct Answer:</label>
                    <input type="text" name="questions[<?php echo $question['id_question']; ?>][answer]" value="<?php echo htmlspecialchars($question['reponse']); ?>" required>
                </li>
            <?php endforeach; ?>
        </ul>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
