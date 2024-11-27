<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Fetch courses from the database
try {
    $db = config::getConnexion();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Enable error reporting
    $sql = "SELECT * FROM course";  // Fetch all courses
    $query = $db->prepare($sql);
    $query->execute();
    $courses = $query->fetchAll();
} catch (Exception $e) {
    $_SESSION['message'] = 'Error fetching courses: ' . $e->getMessage();
}

// Handle course deletion
if (isset($_GET['id'])) {
    $courseId = $_GET['id'];

    try {
        $db = config::getConnexion();
        // Check if the course exists
        $checkQuery = "SELECT COUNT(*) FROM course WHERE id_form = :courseId";
        $checkStmt = $db->prepare($checkQuery);
        $checkStmt->execute([':courseId' => $courseId]);
        $courseExists = $checkStmt->fetchColumn();

        if ($courseExists == 0) {
            $_SESSION['message'] = 'Course not found.';
        } else {
            // Delete the course from the database
            $deleteQuery = "DELETE FROM course WHERE id_form = :courseId";
            $deleteStmt = $db->prepare($deleteQuery);
            $deleteStmt->execute([':courseId' => $courseId]);

            $_SESSION['message'] = 'Course deleted successfully.';
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error deleting course: ' . $e->getMessage();
    }

    // Redirect back to the same page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management</title>
    <link rel="stylesheet" href="./css/StylesEditCourses.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="./images/wajahni2.png" alt="Logo" class="logo">
        <a href="#" class="active">Dashboard</a>
        <a href="#">Courses</a>
        <a href="#">Upload Files</a>
        <a href="#">Create Section</a>
        <a href="#">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Manage Courses</h2>

        <!-- Display success or error message -->
        <?php if (isset($_SESSION['message'])): ?>
            <p style="color: red;"><?php echo $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <!-- Courses Table -->
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td><?= htmlspecialchars($course['id_form']); ?></td>
                            <td><?= htmlspecialchars($course['nom_form']); ?></td>
                            <td><?= htmlspecialchars($course['description']); ?></td>
                            <td><?= htmlspecialchars($course['price']); ?></td>
                            <td><?= htmlspecialchars($course['category_id']); ?></td>
                            <td>
                                <a href="?id=<?= $course['id_form']; ?>" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No courses found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
