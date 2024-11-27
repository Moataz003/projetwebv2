<?php
require_once '../model/Quiz.php';
require_once '../model/Question.php';

// Fetch quiz by ID
if (isset($_GET['quizId'])) {
    $quizId = $_GET['quizId'];
    $quiz = Quiz::getQuizById($quizId);
    $questions = Question::getQuestionsByQuiz($quizId);
} else {
    die('Quiz ID is missing!');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <style>
        /* Global styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            text-transform: uppercase;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin: 0 auto;
            max-width: 800px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: inline-block;
            color: #333;
        }

        .quiz-input {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .quiz-input:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: 2px #007bff;
            border-style: solid;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        button:hover {
            background-color: white;
            color: #0056b3;
            border: 2px #0056b3;
            border-style: solid;
        }

        .question {
            margin-bottom: 25px;
        }

        h3 {
            font-size: 1.2rem;
            color: #007bff;
            margin-bottom: 15px;
        }

        #questions-container {
            margin-bottom: 20px;
        }

        .btn-add {
            background-color: #0cc0df;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            border: 2px #0cc0df;
            border-style: solid;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-add:hover {
            background-color: white;
            color: #0cc0df;
            border: 2px #0cc0df;
            border-style: solid;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            form {
                width: 90%;
            }

            button {
                font-size: 0.9rem;
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($quiz['titre_quiz']); ?></h1>
    <form action="submitQuiz.php" method="POST">
        <input type="hidden" name="quizId" value="<?php echo $quizId; ?>">
        
        <?php foreach ($questions as $question): ?>
            <h4><?php echo htmlspecialchars($question['question']); ?></h4>
            
            <input type="radio" name="answers[<?php echo $question['id_question']; ?>]" value="<?php echo htmlspecialchars($question['option1']); ?>">
            <?php echo htmlspecialchars($question['option1']); ?><br>

            <input type="radio" name="answers[<?php echo $question['id_question']; ?>]" value="<?php echo htmlspecialchars($question['option2']); ?>">
            <?php echo htmlspecialchars($question['option2']); ?><br>

            <input type="radio" name="answers[<?php echo $question['id_question']; ?>]" value="<?php echo htmlspecialchars($question['option3']); ?>">
            <?php echo htmlspecialchars($question['option3']); ?><br>
        <?php endforeach; ?>
        
        <button type="submit">Submit Quiz</button>
    </form>
</body>
</html>
