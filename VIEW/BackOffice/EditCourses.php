<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Fetch all courses for the dropdown menu
try {
    $db = config::getConnexion();
    $sql = "SELECT id_form, nom_form FROM course";
    $query = $db->prepare($sql);
    $query->execute();
    $courses = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $_SESSION['message'] = 'Error fetching courses: ' . $e->getMessage();
    $courses = [];
}

// Handle course update with file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $courseID = $_POST['course_id']; // Corresponds to 'id_form'
    $courseName = htmlspecialchars($_POST['courseName']);
    $price = $_POST['price'];
    $description = htmlspecialchars($_POST['description']);
    $categoryID = $_POST['category']; // Selected category ID
    $filePath = NULL;

    // Check if a file is uploaded
    if (isset($_FILES['file']['name']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        // Define allowed file types
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

        // Get the file details
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
        $fileSize = $_FILES['file']['size'];

        // Validate file type and size (max size of 2MB)
        if (in_array($fileType, $allowedTypes) && $fileSize <= 2 * 1024 * 1024) {
            // Generate a unique file name to avoid conflicts
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileNameNew = uniqid('thumbnail_', true) . '.' . $fileExtension;
            $uploadDir = 'C:/xampp/htdocs/ProjetWeb/VIEW/CoursesThumbnail/';

            // Ensure the directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filePath = $uploadDir . $fileNameNew;

            // Move the uploaded file to the desired folder
            if (!move_uploaded_file($fileTmpName, $filePath)) {
                $_SESSION['message'] = 'Error uploading file.';
                header("Location: EditCourses.php?id=" . $courseID);
                exit;
            }

            // Store the full path for the database (prepend /projetweb/)
            $filePathForDB = '/projetweb/' . 'VIEW/CoursesThumbnail/' . $fileNameNew;
        } else {
            $_SESSION['message'] = 'Invalid file type or file size too large.';
            header("Location: EditCourses.php?id=" . $courseID);
            exit;
        }
    }

    // Check if inputs are not empty
    if (!empty($courseName) && !empty($description) && !empty($price) && !empty($categoryID)) {
        try {
            $db = config::getConnexion();

            // Update the course details in the database
            $sql = "UPDATE course 
                    SET nom_form = :courseName, 
                        price = :price, 
                        description = :description,
                        category_id = :categoryID" . 
                    ($filePathForDB ? ", thumbnail_path = :filePath" : "") . 
                    " WHERE id_form = :courseID";

            $params = [
                ':courseName' => $courseName,
                ':price' => $price,
                ':description' => $description,
                ':categoryID' => $categoryID,
                ':courseID' => $courseID
            ];

            // Add the file path if a file was uploaded
            if ($filePathForDB) {
                $params[':filePath'] = $filePathForDB;
            }

            $query = $db->prepare($sql);
            $query->execute($params);

            // Set success message and redirect to ManageCourses.php
            $_SESSION['message'] = 'Course updated successfully.';
            header("Location: ManageCourses.php");
            exit;
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error updating course: ' . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = 'Please fill in all fields.';
    }
}

// Fetch categories for the dropdown menu
try {
    $db = config::getConnexion();
    $sql = "SELECT CategoryID, name FROM category";
    $query = $db->prepare($sql);
    $query->execute();
    $categories = $query->fetchAll();
} catch (Exception $e) {
    $_SESSION['message'] = 'Error fetching categories: ' . $e->getMessage();
}

// Fetch selected course details for pre-filling the form
$course = null;
if (isset($_GET['id'])) { // 'id' is passed in the query string
    $courseID = $_GET['id'];

    try {
        $sql = "SELECT * FROM course WHERE id_form = :courseID";
        $query = $db->prepare($sql);
        $query->execute([':courseID' => $courseID]);
        $course = $query->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error fetching course details: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
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

            <!-- Edit Course Form -->
            <div class="form-container">
                <h2>Edit Course</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Course Selection -->
                    <div class="form-group">
                        <label for="course">Select Course:</label>
                        <select id="course" name="course_id" required>
                            <option value="" disabled selected>Select a course</option>
                            <?php foreach ($courses as $courseOption): ?>
                                <option value="<?= $courseOption['id_form'] ?>" 
                                    <?= isset($courseID) && $courseID == $courseOption['id_form'] ? 'selected' : '' ?> >
                                    <?= htmlspecialchars($courseOption['nom_form']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select id="category" name="category" required>
                            <option value="" disabled selected>Select a category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['CategoryID'] ?>"
                                    <?= isset($course) && $course['category_id'] == $category['CategoryID'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Course Name -->
                    <div class="form-group">
                        <label for="courseName">Course Name:</label>
                        <input type="text" id="courseName" name="courseName" 
                               value="<?= isset($course) ? htmlspecialchars($course['nom_form']) : '' ?>" 
                               placeholder="Enter course name" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="3" 
                                  placeholder="Enter course description" required><?= isset($course) ? htmlspecialchars($course['description']) : '' ?></textarea>
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label for="price">Price ($):</label>
                        <input type="number" id="price" name="price" 
                               value="<?= isset($course) ? htmlspecialchars($course['price']) : '' ?>" 
                               placeholder="Enter course price" min="0" required>
                    </div>

                    <!-- Thumbnail Upload -->
                    <div class="form-group">
                        <label for="file">Course Thumbnail:</label>
                        <input type="file" id="file" name="file" accept="image/jpeg, image/png, image/gif, application/pdf">
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" name="submit">Update Course</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
