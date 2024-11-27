<?php
require_once '../controller/quizController.php'; // This will handle fetching the quizzes

// Assuming $quizzes variable is populated by the controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Quizzes</title>
    <style>
        /* General styles */
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

        /* Quiz list styles */
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

        strong {
            color: #2c3e50;
            font-size: 1.2em;
        }

        /* Styling for nested question and options */
        .question-list {
            padding-left: 20px;
            margin-top: 10px;
        }

        .question-list li {
            background-color: #f9f9f9;
            border-left: 3px solid #3498db;
            margin-bottom: 10px;
            padding-left: 15px;
        }

        .options {
            margin-left: 20px;
            padding: 10px;
            background-color: #ecf0f1;
            border-radius: 5px;
        }

        .options li {
            margin: 5px 0;
        }

        /* Styling for the answers */
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
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
