<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Handle form submission (Add Course)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $courseName = htmlspecialchars($_POST['courseName']);
    $description = htmlspecialchars($_POST['description']);
    $price = $_POST['price'];
    $categoryID = $_POST['category']; // Selected category ID

    // Check if inputs are not empty
    if (!empty($courseName) && !empty($description) && !empty($price) && !empty($categoryID)) {
        try {
            $db = config::getConnexion();

            // Insert new course into the database
            $sql = "INSERT INTO course (nom_form, description, price, category_id) VALUES (:courseName, :description, :price, :categoryID)";
            $query = $db->prepare($sql);
            $query->execute([
                ':courseName' => $courseName,
                ':description' => $description,
                ':price' => $price,
                ':categoryID' => $categoryID
            ]);

            // Set success message and redirect to ManageCourses.php
            $_SESSION['message'] = 'Course added successfully.';
            header("Location: ManageCourses.php");
            exit;
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error adding course: ' . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = 'Please fill in all fields.';
    }
}

// Fetch categories for the dropdown menu
try {
    $db = config::getConnexion();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error reporting
    $sql = "SELECT CategoryID, name FROM category"; // Fetch categories
    $query = $db->prepare($sql);
    $query->execute();
    $categories = $query->fetchAll();
} catch (Exception $e) {
    $_SESSION['message'] = 'Error fetching categories: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="./css/COURSES.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <img src="./images/wajahni2.png" alt="Logo" class="logo">
            <nav>
                <a href="#">Dashboard</a>
                <a href="#">Add Course</a>
                <a href="#">Edit Course</a>
                <a href="#">Settings</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <div class="profile">Admin</div>
            </header>

            <!-- Add Course Form -->
            <div class="form-container">
                <h2>Add Course</h2>
                <form action="" method="POST">
                    <!-- Category -->
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select id="category" name="category" required>
                            <option value="" disabled selected>Select a category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['CategoryID'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Course Name -->
                    <div class="form-group">
                        <label for="courseName">Course Name:</label>
                        <input type="text" id="courseName" name="courseName" placeholder="Enter course name" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="3" placeholder="Enter course description" required></textarea>
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label for="price">Price ($):</label>
                        <input type="number" id="price" name="price" placeholder="Enter course price" min="0" step="0.01" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <script>
            window.alert("<?= $_SESSION['message'] ?>");
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</body>
</html>
