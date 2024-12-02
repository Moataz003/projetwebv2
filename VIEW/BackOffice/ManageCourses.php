<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Fetch courses and their categories from the database
try {
    $db = config::getConnexion();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error reporting

    // Join the course and category tables to get category name
    $sql = "SELECT course.id_form, course.nom_form, course.description, course.price, category.name AS category_name 
            FROM course 
            LEFT JOIN category ON course.category_id = category.CategoryID"; // Join condition

    $query = $db->prepare($sql);
    $query->execute();
    $courses = $query->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Manage Courses</title>
    <link rel="stylesheet" href="./css/CoursesManagement.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <img src="./images/wajahni2.png" alt="Logo" class="logo">
            <nav>
                <a href="#">Dashboard</a>
                <a href="#">Courses</a>
                <a href="#">Upload Files</a>
                <a href="#">Create Section</a>
                <a href="#">Settings</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <div class="profile">Admin</div>
            </header>

            <!-- Course Table -->
            <div class="form-container">
                <h2>Courses</h2>
                <form action="AddCourse.php">
                    <button type="submit" class="delete-button">Add Course</button>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Course Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th style="text-align: center; padding-left: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?= htmlspecialchars($course['id_form']) ?></td>
                <td><?= htmlspecialchars($course['nom_form']) ?></td>
                <td><?= htmlspecialchars($course['description']) ?></td>
                <td><?= htmlspecialchars($course['price']) ?></td>
                <!-- Display the category name instead of category_id -->
                <td><?= htmlspecialchars($course['category_name'] ?? 'No Category') ?></td>
                <td style="text-align: right;">
                    <!-- Delete Button -->
                    <form action="" method="get" style="display: inline-block;">
                        <input type="hidden" name="id" value="<?= $course['id_form'] ?>">
                        <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this course?');">Delete</button>
                    </form>

                    <!-- Edit Button -->
                    <form action="EditCourses.php" method="get" style="display: inline-block;">
                        <input type="hidden" name="id" value="<?= $course['id_form'] ?>">
                        <button type="submit" class="edit-button">Edit</button>
                    </form>
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

                <!-- Pagination -->
                <div class="pagination">
                    <!-- No pagination for this example -->
                </div>
            </div>
        </main>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <script>
            window.alert("<?php echo $_SESSION['message']; ?>");
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</body>
</html>
