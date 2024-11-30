<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Check if the form is submitted to update the category
if (isset($_POST['submit'])) {
    $categoryId = $_POST['category_id'];
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);

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
                $sql = "UPDATE category SET Name = :name, Description = :description WHERE CategoryID = :category_id";
                $query = $db->prepare($sql);
                $query->execute([
                    ':name' => $name,
                    ':description' => $description,
                    ':category_id' => $categoryId
                ]);
                $_SESSION['message'] = 'Category updated successfully.';
            }
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error updating category: ' . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = 'Please fill in all fields.';
    }

    // After the category is updated, redirect to DeleteCategory.php
    header("Location: ManageCategory.php");
    exit;
}

// Fetch the category to edit based on the category_id passed in the URL
if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
    try {
        $db = config::getConnexion();
        $sql = "SELECT CategoryID, Name, Description FROM category WHERE CategoryID = :category_id";
        $query = $db->prepare($sql);
        $query->execute([':category_id' => $categoryId]);
        $category = $query->fetch();
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error fetching category: ' . $e->getMessage();
        header("Location: ManageCategory.php"); // Redirect to DeleteCategory.php if an error occurs
        exit;
    }
} else {
    $_SESSION['message'] = 'Category ID is required to edit.';
    header("Location: ManageCategory.php"); // Redirect to DeleteCategory.php if no category ID is provided
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
        <!-- Sidebar -->
        <aside class="sidebar">
            <img src="./images/wajahni2.png" alt="Logo" class="logo">
            <nav>
                <a href="#">Dashboard</a>
                <a href="add_category.php">Add Category</a>
                <a href="delete_category.php">Delete Category</a>
                <a href="#">Settings</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <div class="profile">Admin</div>
            </header>

            <div class="form-container">
                <h2>Edit Category</h2>
                <!-- Form submits to the same page (EditCategory.php) -->
                <form action="EditCategory.php" method="post">
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
