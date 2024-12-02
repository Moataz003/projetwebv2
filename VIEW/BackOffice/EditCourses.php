<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Fetch all courses for the dropdown menu
try {
    $db = config::getConnexion();
    $sql = "SELECT id_form, nom_form FROM course"; // Fetch course ID and name
    $query = $db->prepare($sql);
    $query->execute();
    $courses = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $_SESSION['message'] = 'Error fetching courses: ' . $e->getMessage();
    $courses = [];
}

// Handle course update
if (isset($_POST['update'])) {
    $courseID = $_POST['course_id']; // Corresponds to 'id_form'
    $courseName = htmlspecialchars($_POST['course_name']);
    $price = $_POST['course_price'];
    $description = htmlspecialchars($_POST['course_description']);
    $categoryID = $_POST['course_category'];

    try {
        // Update the course details in the database
        $sql = "UPDATE course 
                SET nom_form = :courseName, 
                    price = :price, 
                    description = :description, 
                    category_id = :categoryID 
                WHERE id_form = :courseID";
        $query = $db->prepare($sql);
        $query->execute([
            ':courseName' => $courseName,
            ':price' => $price,
            ':description' => $description,
            ':categoryID' => $categoryID,
            ':courseID' => $courseID
        ]);

        $_SESSION['message'] = 'Course updated successfully.';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error updating course: ' . $e->getMessage();
    }

    header("Location: EditCourses.php");
    exit;
}

// Fetch selected course details for pre-filling the form
$course = null;
if (isset($_GET['id'])) { // 'id' is passed in the query string
    $courseID = $_GET['id'];

    try {
        $sql = "SELECT * FROM course WHERE id_form = :courseID"; // Use 'id_form' to fetch the course
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
    <title>Course Editing</title>
    <link rel="stylesheet" href="./css/StylesManageCourses.css">
</head>
<body>
    <div class="sidebar">
        <img src="./images/wajahni2.png" alt="Logo" class="logo">
        <a href="#" class="active">Dashboard</a>
        <a href="#">Courses</a>
        <a href="#">Upload Files</a>
        <a href="#">Create Section</a>
        <a href="#">Settings</a>
    </div>

    <div class="main-content">
        <h2>Update Course</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="courses">Choose a course:</label>
                <select id="courses" name="course_id" required>
                    <option value="" disabled selected>Select a course</option>
                    <?php foreach ($courses as $item): ?>
                        <option value="<?= $item['id_form'] ?>" 
                            <?= isset($courseID) && $courseID == $item['id_form'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($item['nom_form']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <?php if ($course): ?>
                <div class="form-group">
                    <label for="course_name">Course Name:</label>
                    <input type="text" id="course_name" name="course_name" value="<?= htmlspecialchars($course['nom_form']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="course_price">Price:</label>
                    <input type="number" id="course_price" name="course_price" value="<?= htmlspecialchars($course['price']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="course_description">Description:</label>
                    <textarea id="course_description" name="course_description" required><?= htmlspecialchars($course['description']) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="course_category">Category ID:</label>
                    <input type="number" id="course_category" name="course_category" value="<?= htmlspecialchars($course['category_id']) ?>" required>
                </div>
                <button type="submit" name="update">Update Course</button>
            <?php else: ?>
                <p>Please select a course to edit.</p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
