<?php
// Include the necessary files
require_once '../controller/quizController.php';

// Check if quiz ID is provided in the URL (e.g., updateQuiz.php?quizId=1)
if (isset($_GET['quizId']) && !empty($_GET['quizId'])) {
    $quizId = $_GET['quizId'];
    $quiz = Quiz::getQuizById($quizId); // Fetch the quiz from the database

    if (!$quiz) {
        echo "Quiz not found!";
        exit();
    }
} else {
    echo "Quiz ID is missing!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Quiz</title>
    <script>
        let questionCount = <?php echo count($questions); ?>;

        // Add a new question field set (not needed here, as you are editing existing questions)
        function addQuestion() {
            questionCount++;
            const container = document.getElementById('questions-container');
            const newQuestion = `
                <div>
                    <h3>Question ${questionCount}</h3>
                    <label>Question:</label><input type="text" name="questions[${questionCount}][question]" id="question-${questionCount}" class="quiz-input"><br>
                    <label>Option 1:</label><input type="text" name="questions[${questionCount}][option1]" id="option1-${questionCount}" class="quiz-input"><br>
                    <label>Option 2:</label><input type="text" name="questions[${questionCount}][option2]" id="option2-${questionCount}" class="quiz-input"><br>
                    <label>Option 3:</label><input type="text" name="questions[${questionCount}][option3]" id="option3-${questionCount}" class="quiz-input"><br>
                    <label>Answer:</label><input type="text" name="questions[${questionCount}][response]" id="response-${questionCount}" class="quiz-input"><br>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newQuestion);
        }

        // Validate the form before submission
        function validateForm(event) {
            const quizTitle = document.getElementsByName('quiz_title')[0].value.trim();
            const questionInputs = document.querySelectorAll('.quiz-input');
            const titlePattern = /^[a-zA-Z0-9\s]+$/; // Pattern to allow only letters, numbers, and spaces

            // Check if quiz title is empty or contains special characters
            if (quizTitle === "") {
                alert("Quiz title is required.");
                event.preventDefault();
                return false;
            }

            if (!titlePattern.test(quizTitle)) {
                alert("Quiz title cannot contain special characters.");
                event.preventDefault();
                return false;
            }

            // Check if any question or options have leading/trailing spaces
            for (let input of questionInputs) {
                const value = input.value.trim();
                if (value === "") {
                    alert("All fields must be filled.");
                    input.focus();
                    event.preventDefault();
                    return false;
                }
                input.value = value; // Trim the input value to remove spaces
            }

            return true;
        }
    </script>
</head>
<body>
    <h1>Update Quiz</h1>
    <form action="../controller/quizController.php" method="POST" onsubmit="return validateForm(event)">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz['id_quiz']; ?>"> <!-- Hidden field for quiz ID -->
        
        <label>Quiz Title:</label>
        <input type="text" name="quiz_title" value="<?php echo htmlspecialchars($quiz['titre_quiz']); ?>" id="quiz_title" class="quiz-input"><br>

        <h3>Questions</h3>
        <?php
        // Fetch existing questions for this quiz
        $questions = Question::getQuestionsByQuiz($quiz['id_quiz']);
        foreach ($questions as $index => $question) {
            ?>
            <div>
                <h4>Question <?php echo $index + 1; ?></h4>
                <label>Question:</label><input type="text" name="questions[<?php echo $question['id_question']; ?>][question]" value="<?php echo htmlspecialchars($question['question']); ?>" class="quiz-input"><br>
                <label>Option 1:</label><input type="text" name="questions[<?php echo $question['id_question']; ?>][option1]" value="<?php echo htmlspecialchars($question['option1']); ?>" class="quiz-input"><br>
                <label>Option 2:</label><input type="text" name="questions[<?php echo $question['id_question']; ?>][option2]" value="<?php echo htmlspecialchars($question['option2']); ?>" class="quiz-input"><br>
                <label>Option 3:</label><input type="text" name="questions[<?php echo $question['id_question']; ?>][option3]" value="<?php echo htmlspecialchars($question['option3']); ?>" class="quiz-input"><br>
                <label>Answer:</label><input type="text" name="questions[<?php echo $question['id_question']; ?>][response]" value="<?php echo htmlspecialchars($question['reponse']); ?>" class="quiz-input"><br>
            </div>
            <?php
        }
        ?>

        <button type="submit" name="update_quiz">Update Quiz</button>
    </form>
</body>
</html>



<!-- updateQuiz.php?quizId=1 -->