<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Path to the folder where images will be saved
$thumbnailDir = '/projetweb/VIEW/CategoriesThumbnail/'; // Updated path

// Check if the form is submitted to update the category
if (isset($_POST['submit'])) {
    $categoryId = $_POST['category_id'];
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $thumbnailPath = null;

    // Handle file upload
    if (!empty($_FILES['thumbnail']['name'])) {
        $fileName = basename($_FILES['thumbnail']['name']);
        $targetFile = $_SERVER['DOCUMENT_ROOT'] . $thumbnailDir . $fileName; // Full file path
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate the uploaded file
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetFile)) {
                $thumbnailPath = $thumbnailDir . $fileName; // Save relative path
            } else {
                $_SESSION['message'] = 'Error uploading thumbnail.';
                header("Location: EditCategory.php?category_id=" . $categoryId);
                exit;
            }
        } else {
            $_SESSION['message'] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.';
            header("Location: EditCategory.php?category_id=" . $categoryId);
            exit;
        }
    }

    if (!empty($name) && !empty($description)) {
        try {
            $db = config::getConnexion();

            // Check if a category with this name already exists (except for the current category)
            $checkQuery = "SELECT COUNT(*) FROM category WHERE Name = :name AND CategoryID != :category_id";
            $checkStmt = $db->prepare($checkQuery);
            $checkStmt->execute([':name' => $name, ':category_id' => $categoryId]);
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                $_SESSION['message'] = 'Error: A category with this name already exists.';
            } else {
                // Update the category
                $sql = "UPDATE category SET Name = :name, Description = :description";
                $params = [
                    ':name' => $name,
                    ':description' => $description,
                    ':category_id' => $categoryId
                ];

                // Include thumbnail update if a new file is uploaded
                if ($thumbnailPath !== null) {
                    $sql .= ", Thumbnail = :thumbnail";
                    $params[':thumbnail'] = $thumbnailPath;
                }

                $sql .= " WHERE CategoryID = :category_id";
                $query = $db->prepare($sql);
                $query->execute($params);

                $_SESSION['message'] = 'Category updated successfully.';
            }
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error updating category: ' . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = 'Please fill in all fields.';
    }

    // After the category is updated, redirect to ManageCategory.php
    header("Location: ManageCategory.php");
    exit;
}

// Fetch the category to edit based on the category_id passed in the URL
if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
    try {
        $db = config::getConnexion();
        $sql = "SELECT CategoryID, Name, Description, Thumbnail FROM category WHERE CategoryID = :category_id";
        $query = $db->prepare($sql);
        $query->execute([':category_id' => $categoryId]);
        $category = $query->fetch();
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error fetching category: ' . $e->getMessage();
        header("Location: ManageCategory.php");
        exit;
    }
} else {
    $_SESSION['message'] = 'Category ID is required to edit.';
    header("Location: ManageCategory.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="./css/CategoryManagement.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <img src="./images/wajahni2.png" alt="Logo" class="logo">
            <nav>
                <a href="#">Dashboard</a>
                <a href="add_category.php">Add Category</a>
                <a href="delete_category.php">Delete Category</a>
                <a href="#">Settings</a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <div class="profile">Admin</div>
            </header>
            <div class="form-container">
                <h2>Edit Category</h2>
                <form action="EditCategory.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="category_id" value="<?= $category['CategoryID'] ?>">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($category['Name']) ?>" placeholder="Enter category name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="5" placeholder="Enter category description"><?= htmlspecialchars($category['Description']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail:</label>
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                        <?php if (!empty($category['Thumbnail'])): ?>
                            <img src="<?= htmlspecialchars($category['Thumbnail']) ?>" alt="Thumbnail" style="width:100px; height:auto;">
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit">Update Category</button>
                    </div>
                </form>
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
