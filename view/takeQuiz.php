<?php
require_once '../model/Quiz.php';
require_once '../model/Question.php';

if (isset($_GET['quizId'])) {
    $quizId = $_GET['quizId'];
    $quiz = Quiz::getQuizById($quizId);
    $questions = Question::getQuestionsByQuiz($quizId);
} else {
    die('Quiz ID is missing!');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    $email = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="frontoffice/lib/animate/animate.min.css" rel="stylesheet">
    <link href="frontoffice/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="frontoffice/css/bootstrap.min.css" rel="stylesheet">
    <link href="frontoffice/css/style.css" rel="stylesheet">
    <style>
        .button-group {
            flex-grow: 1;
            margin: auto;
        }
        .button-group input[type="radio"] {
            display: none;
        }
        .button-group label {
            display: inline-block;
            padding: 10px 20px;
            cursor: pointer;
            border: 1px solid #2b426d;
            background-color: #385c7e;
            color: white;
            border-radius: 15px;
            transition: all ease 0.2s;
            text-align: center;
            flex-grow: 1;
            flex-basis: 0;
            width: 90px;
            font-size: 13px;
            margin: 5px;
            box-shadow: 0px 0px 50px -15px #000000;
        }
        .button-group input[type="radio"]:checked + label {
            background-color: white;
            color: #02375a;
            border: 1px solid #2b426d;
        }
        fieldset {
            border: 0;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            padding: 20px;
            margin: auto;
            width: 80%;
            max-width: 800px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background: #0cc0df;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php if ($email === ''): ?>

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
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="signup.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Sign Up</a>
        </div>
    </nav>
    <br><br><br><br>
    <div class="container">
        <h2 class="text-center">Enter Your Email to Start the Quiz</h2>
        <form action="takeQuiz.php?quizId=<?php echo $quizId; ?>" method="POST">
            <input type="email" name="email" required placeholder="Enter your email" class="form-control mb-3" />
            <button type="submit" class="btn btn-primary w-100">Start Quiz</button>
        </form>
    </div>
<?php else: ?>
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
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="signup.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Sign Up</a>
        </div>
    </nav>
    <h1><?php echo htmlspecialchars($quiz['titre_quiz']); ?></h1>
    <form action="submitQuiz.php" method="POST">
        <input type="hidden" name="quizId" value="<?php echo $quizId; ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <?php foreach ($questions as $question): ?>
            <fieldset>
                <legend><?php echo htmlspecialchars($question['question']); ?></legend>
                <div class="d-flex flex-column w-25">
                    <div class="button-group">
                        <input type="radio" id="option1-<?php echo $question['id_question']; ?>" name="answers[<?php echo $question['id_question']; ?>]" value="<?php echo htmlspecialchars($question['option1']); ?>">
                        <label for="option1-<?php echo $question['id_question']; ?>"><?php echo htmlspecialchars($question['option1']); ?></label>
                    </div>
                    <div class="button-group">
                        <input type="radio" id="option2-<?php echo $question['id_question']; ?>" name="answers[<?php echo $question['id_question']; ?>]" value="<?php echo htmlspecialchars($question['option2']); ?>">
                        <label for="option2-<?php echo $question['id_question']; ?>"><?php echo htmlspecialchars($question['option2']); ?></label>
                    </div>
                    <div class="button-group">
                        <input type="radio" id="option3-<?php echo $question['id_question']; ?>" name="answers[<?php echo $question['id_question']; ?>]" value="<?php echo htmlspecialchars($question['option3']); ?>">
                        <label for="option3-<?php echo $question['id_question']; ?>"><?php echo htmlspecialchars($question['option3']); ?></label>
                    </div>
                </div>
            </fieldset>
        <?php endforeach; ?>
        <button type="submit">Submit Quiz</button>
    </form>
<?php endif; ?>

</body>
</html>
