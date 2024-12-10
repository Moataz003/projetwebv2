<?php
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/Project/controller');
require('quizController.php');
// Assuming $quizzes variable is populated by the controller
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/Project/controller');
    require('quizController.php');

    $idQuiz = $_POST['id_quiz'];

    if (!empty($idQuiz)) {
        // Call the necessary delete methods from the controller
        Question::deleteByQuizId($idQuiz);
        Quiz::delete($idQuiz);

        // Redirect back to the quizzes page to refresh the list
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Quizzes</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #3e3e3e;
            margin-top: 30px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 20px 0;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        li:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .button-container {
            margin-top: 10px;
        }

        button {
            margin: 0 5px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .update-btn {
            background-color: #3498db;
            color: white;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .update-btn:hover {
            background-color: #2980b9;
        }

        .question-list {
            padding-left: 20px;
            margin-top: 10px;
        }

        .options {
            margin-left: 20px;
            padding: 10px;
            background-color: #ecf0f1;
            border-radius: 5px;
        }

        .answer {
            font-weight: bold;
            color: #27ae60;
        }
    </style>
</head>
<body>
    <h1>List of Quizzes</h1>
    <ul>
        <?php foreach ($quizzes as $quiz): ?>
            <li>
                <strong><?php echo htmlspecialchars($quiz['titre_quiz']); ?></strong>
                <ul class="question-list">
                    <?php
                    $questions = Question::getQuestionsByQuiz($quiz['id_quiz']);
                    foreach ($questions as $question): ?>
                        <li>
                            <?php echo htmlspecialchars($question['question']); ?><br>
                            <div class="options">
                                <strong>Options:</strong>
                                <ul>
                                    <li><?php echo htmlspecialchars($question['option1']); ?></li>
                                    <li><?php echo htmlspecialchars($question['option2']); ?></li>
                                    <li><?php echo htmlspecialchars($question['option3']); ?></li>
                                </ul>
                            </div>
                            <div class="answer">
                                <strong>Answer:</strong> <?php echo htmlspecialchars($question['reponse']); ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="button-container">
                    <form action="../updateQuiz.php" method="GET" style="display: inline;">
                        <input type="hidden" name="id_quiz" value="<?php echo htmlspecialchars($quiz['id_quiz']); ?>">
                        <button class="update-btn" type="submit">Update</button>
                    </form>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id_quiz" value="<?php echo htmlspecialchars($quiz['id_quiz']); ?>">
                        <button class="delete-btn" type="submit" onclick="return confirm('Are you sure you want to delete this quiz?')">Delete</button>
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
