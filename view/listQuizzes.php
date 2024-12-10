<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the Quiz model
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/Project/model');
require_once('Quiz.php');

// Initialize Quiz model
$quizModel = new Quiz();

// Handle search functionality
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search']; // Get the search term from the URL
    $quizzes = $quizModel->searchQuizzesByName($searchQuery); // Fetch quizzes matching the search term
} else {
    $quizzes = $quizModel->getAllQuizzes(); // Fetch all quizzes if no search term is provided
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz List</title>
</head>
<body>
    <!-- Search Form -->
    <form method="GET" action="" class="d-flex">
        <input type="text" class="form-control w-25 mx-1" name="search" placeholder="Search by quiz name" value="<?= htmlspecialchars($searchQuery) ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php
    // Display quizzes or a message if no quizzes found
    if (empty($quizzes)) {
        echo "<p>No quizzes available at the moment.</p>";
    } else {
    ?>
        <h1 class="mt-4">Select a Quiz to Take</h1>
        <div class="row d-flex">
            <?php foreach ($quizzes as $quiz): ?>
                <a width="200" height="200" class="col-12 col-md-6 col-lg-2 rounded my-2 d-flex flex-column" href="../takeQuiz.php?quizId=<?php echo $quiz['id_quiz']; ?>">
                    <img class="rounded-top" src="https://imgs.search.brave.com/dLI4I6PPCo5v3wIXfpSy-KFcbSU4mSFxdeu7UD_FPtc/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/dmVjdG9yc3RvY2su/Y29tL2kvcHJldmll/dy0xeC8wOC8wNS9x/dWl6LXRlc3QtYmFj/a2dyb3VuZC13aXRo/LXF1ZXN0aW9uLW1h/cmtzLXZlY3Rvci0x/MTgzMDgwNS5qcGc" alt="">
                    <div class="text-center">
                        <?php echo htmlspecialchars($quiz['titre_quiz']); ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php
    }
    ?>
</body>
</html>
