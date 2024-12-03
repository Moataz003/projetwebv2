<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $courseName = htmlspecialchars($_POST['courseName']);
    $description = htmlspecialchars($_POST['description']);
    $price = $_POST['price'];
    $categoryID = $_POST['category']; // Selected category ID

    if (!empty($courseName) && !empty($description) && !empty($price) && !empty($categoryID)) {
        try {
            // Handle thumbnail upload
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $thumbnail = $_FILES['thumbnail'];
                $thumbnailType = mime_content_type($thumbnail['tmp_name']);

                // Validate file type
                if (!in_array($thumbnailType, $allowedTypes)) {
                    throw new Exception("Invalid file type. Only JPG and PNG are allowed.");
                }

                

                // Generate unique file name and move the file
                $targetDir = "C:/xampp/htdocs/ProjetWeb/VIEW/CoursesThumbnail/";
                $fileName = uniqid() . "_" . basename($thumbnail['name']);
                $targetFilePath = $targetDir . $fileName;

                if (!move_uploaded_file($thumbnail['tmp_name'], $targetFilePath)) {
                    throw new Exception("Failed to upload the thumbnail.");
                }

                // Insert course details into the database
                $db = config::getConnexion();
                $sql = "INSERT INTO course (nom_form, description, price, category_id, thumbnail_path)
                        VALUES (:courseName, :description, :price, :categoryID, :thumbnailPath)";
                $query = $db->prepare($sql);
                $query->execute([
                    ':courseName' => $courseName,
                    ':description' => $description,
                    ':price' => $price,
                    ':categoryID' => $categoryID,
                    ':thumbnailPath' => str_replace("C:/xampp/htdocs/", "/", $targetFilePath) // Save relative path
                ]);

                $_SESSION['message'] = 'Course added successfully.';
                header("Location: ManageCourses.php");
                exit;
            } else {
                throw new Exception("Please upload a thumbnail.");
            }
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
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT CategoryID, name FROM category";
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
                <form action="" method="POST" enctype="multipart/form-data">
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

                    <!-- Thumbnail Upload -->
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail</label>
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" required>
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
