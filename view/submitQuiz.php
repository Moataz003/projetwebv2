<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="frontoffice/lib/animate/animate.min.css" rel="stylesheet">
    <link href="frontoffice/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="frontoffice/css/bootstrap.min.css" rel="stylesheet">
    <link href="frontoffice/css/style.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        nav {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .result-section {
            min-height: 89.8vh;
            background-color: #0cc0df;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .result-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .result-section .score {
            font-size: 1.5rem;
            margin-bottom: 30px;
            font-weight: 600;
            color: #white;
        }

        .feedback-container {
            width: 90%;
            max-width: 800px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            padding: 20px;
            color: #333;
        }

        .feedback-container h2 {
            font-size: 1.8rem;
            color: #0cc0df;
            margin-bottom: 15px;
            text-align: center;
        }

        .question-feedback {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .question-feedback:last-child {
            border-bottom: none;
        }

        .question {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .your-answer {
            font-weight: 600;
            color: #d9534f;
        }

        .your-answer.correct {
            color: #5cb85c;
        }

        .correct-answer {
            font-weight: 600;
            color: #0cc0df;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="frontoffice/quizzes.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>Wajahni</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="frontoffice/quizzes.php" class="nav-item nav-link active">Home</a>
            <a href="about.html" class="nav-item nav-link">About</a>
            <a href="courses.html" class="nav-item nav-link">Courses</a>
            <a href="quizzes.php" class="nav-item nav-link">Quizzes</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu fade-down m-0">
                    <a href="team.html" class="dropdown-item">Our Team</a>
                    <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                    <a href="404.html" class="dropdown-item">404 Page</a>
                </div>
            </div>
            <a href="contact.html" class="nav-item nav-link">Contact</a>
        </div>
        <a href="signup.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Sign Up</a>
    </div>
</nav>

<?php
require_once '../model/Quiz.php';
require_once '../model/Question.php';
require '../vendor/autoload.php'; // Include Composer's autoloader for PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['quizId'], $_POST['answers'])) {
        $email = $_POST['email'];
        $quizId = $_POST['quizId'];
        $answers = $_POST['answers'];

        // Get questions and correct answers
        $correctAnswers = [];
        $questions = Question::getQuestionsByQuiz($quizId);

        $questionsById = [];
        foreach ($questions as $question) {
            $questionsById[$question['id_question']] = $question;
            $correctAnswers[$question['id_question']] = $question['reponse'];
        }

        $score = 0;
        $feedback = [];
        foreach ($answers as $questionId => $selectedAnswer) {
            $isCorrect = isset($correctAnswers[$questionId]) && $selectedAnswer == $correctAnswers[$questionId];
            if ($isCorrect) {
                $score++;
            }

            $question = isset($questionsById[$questionId]) ? $questionsById[$questionId]['question'] : 'Question not found';
            $correctAnswer = isset($correctAnswers[$questionId]) ? $correctAnswers[$questionId] : 'Not available';

            $feedback[] = [
                'question' => $question,
                'yourAnswer' => $selectedAnswer,
                'correctAnswer' => $correctAnswer,
                'isCorrect' => $isCorrect,
            ];
        }

        // Display the results
        echo "<div class='result-section'>";
        echo "<h1>Quiz Results</h1>";
        echo "<div class='score'>Your score: $score / " . count($questions) . "</div>";
        echo "<div class='feedback-container'>";
        echo "<h2>Question Feedback</h2>";
        foreach ($feedback as $item) {
            echo "<div class='question-feedback'>";
            echo "<div class='question'>Question: " . htmlspecialchars($item['question']) . "</div>";
            echo "<div class='your-answer " . ($item['isCorrect'] ? 'correct' : '') . "'>Your answer: " . htmlspecialchars($item['yourAnswer']) . ($item['isCorrect'] ? ' (Correct)' : ' (Wrong)') . "</div>";
            echo "<div class='correct-answer'>Correct answer: " . htmlspecialchars($item['correctAnswer']) . "</div>";
            echo "</div>";
        }
        echo "</div></div>";

        // Send email with PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use your mail server here
            $mail->SMTPAuth = true;
            $mail->Username = 'thebestrayen2004@gmail.com'; // Your email address
            $mail->Password = 'zqqcuxdirikcbezv'; // Your email password or app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('your-email@gmail.com', 'Quiz Results');
            $mail->addAddress($email); // Recipient's email address

            // Content
            $mail->isHTML(false);
            $mail->Subject = 'Your Quiz Results';
            $message = "You completed the quiz!\n\nScore: $score / " . count($questions) . "\n\nFeedback:\n";
            foreach ($feedback as $item) {
                $message .= "Question: " . htmlspecialchars($item['question']) . "\n";
                $message .= "Your answer: " . htmlspecialchars($item['yourAnswer']) . ($item['isCorrect'] ? ' (Correct)' : ' (Wrong)') . "\n";
                $message .= "Correct answer: " . htmlspecialchars($item['correctAnswer']) . "\n\n";
            }
            $mail->Body = $message;

            $mail->send();
            echo "Email has been sent to $email!";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<div class='result-section'><p>Some data is missing. Please try again.</p></div>";
    }
} else {
    echo "<div class='result-section'><p>Invalid request method.</p></div>";
}
?>


</body>
</html>
