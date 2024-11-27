<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New Quiz</title>

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

    <script>
        let questionCount = 1;

        // Add a new question field set
        function addQuestion() {
            questionCount++;
            const container = document.getElementById('questions-container');
            const newQuestion = `
                <div class="question">
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

            // Check if quiz title is empty
            if (quizTitle === "") {
                alert("Quiz title is required.");
                event.preventDefault();
                return false;
            }

            // Check if quiz title contains special characters
            if (!titlePattern.test(quizTitle)) {
                alert("Quiz title cannot contain special characters.");
                event.preventDefault();
                return false;
            }

            // Check if any question or options are empty or have leading/trailing spaces
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

    <h1>Add a New Quiz</h1>

    <form action="../../controller/quizController.php" method="POST" onsubmit="return validateForm(event)">
        <label>Quiz Title:</label>
        <input type="text" name="quiz_title" id="quiz_title" class="quiz-input"><br>

        <div id="questions-container">
            <div class="question">
                <h3>Question 1</h3>
                <label>Question:</label><input type="text" name="questions[1][question]" id="question-1" class="quiz-input"><br>
                <label>Option 1:</label><input type="text" name="questions[1][option1]" id="option1-1" class="quiz-input"><br>
                <label>Option 2:</label><input type="text" name="questions[1][option2]" id="option2-1" class="quiz-input"><br>
                <label>Option 3:</label><input type="text" name="questions[1][option3]" id="option3-1" class="quiz-input"><br>
                <label>Answer:</label><input type="text" name="questions[1][response]" id="response-1" class="quiz-input"><br>
            </div>
        </div>

        <button type="button" class="btn-add" onclick="addQuestion()">Add Another Question</button>
        <button type="submit" name="submit_quiz">Submit Quiz</button>
    </form>

</body>
</html>
