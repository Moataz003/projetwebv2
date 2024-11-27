<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Fetch all courses for the dropdown menu
try {
    $db = config::getConnexion();
    $sql = "SELECT CourseID, nom_form FROM course";
    $query = $db->prepare($sql);
    $query->execute();
    $courses = $query->fetchAll();
} catch (Exception $e) {
    $_SESSION['message'] = 'Error fetching courses: ' . $e->getMessage();
}

// Handle course update
if (isset($_POST['update'])) {
    $courseID = $_POST['course_id'];
    $courseName = htmlspecialchars($_POST['course_name']);
    $price = $_POST['course_price'];
    $description = htmlspecialchars($_POST['course_description']);

    // Update the course details in the database
    try {
        $sql = "UPDATE course SET nom_form = :courseName, price = :price, description = :description WHERE CourseID = :courseID";
        $query = $db->prepare($sql);
        $query->execute([
            ':courseName' => $courseName,
            ':price' => $price,
            ':description' => $description,
            ':courseID' => $courseID
        ]);

        $_SESSION['message'] = 'Course updated successfully.';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error updating course: ' . $e->getMessage();
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch selected course details for pre-filling form
if (isset($_GET['course_id'])) {
    $courseID = $_GET['course_id'];

    try {
        $sql = "SELECT nom_form, price, description FROM course WHERE CourseID = :courseID";
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

        <h2>Update Course</h2>
        <!-- Form to choose a course and update it -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="courses">Choose a course:</label>
                <select id="courses" name="course_id" required>
                    <option value="" disabled selected>Select a course</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?= $course['CourseID'] ?>" 
                            <?= isset($courseID) && $courseID == $course['CourseID'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($course['nom_form']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <?php if (isset($course)): ?>
                <!-- Pre-fill course details if a course is selected -->
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
                <button type="submit" name="update">Update Course</button>
            <?php else: ?>
                <p>Please select a course to edit.</p>
            <?php endif; ?>
        </form>

        <h2>Upload Course File (PDF/Video)</h2>
        <form enctype="multipart/form-data">
            <div class="form-group">
                <label for="course_file">Choose File:</label>
                <input type="file" id="course_file" name="course_file" accept=".pdf,.mp4,.avi,.mkv">
            </div>
            <div class="form-group">
                <label for="sections">Choose Section</label>
                <select id="sections">
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                    <option value="opel">Opel</option>
                    <option value="audi">Audi</option>
                </select>
            </div>
            <button type="submit">Upload File</button>
        </form>

        <h2>Create New Section</h2>
        <form>
            <div class="form-group">
                <label for="section_title">Section Title:</label>
                <input type="text" id="section_title" name="section_title">
            </div>
            <div class="form-group">
                <label for="section_course_id">Course ID:</label>
                <input type="text" id="section_course_id" name="section_course_id">
            </div>
            <button type="submit">Create Section</button>
        </form>

    </div>

</body>
</html>
