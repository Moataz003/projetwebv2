<?php
require_once '../controller/quizController.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Quiz</title>
</head>
<body>
    <h1>Delete a Quiz</h1>

    <!-- Display Success or Error Messages -->
    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <!-- List All Quizzes -->
    <ul>
        <?php foreach ($quizzes as $quiz): ?>
            <li>
                <strong><?php echo htmlspecialchars($quiz['titre_quiz']); ?></strong>
                <form action="../controller/quizController.php" method="POST" style="display: inline;">
                    <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz['id_quiz']); ?>">
                    <button type="submit" name="delete_quiz">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
