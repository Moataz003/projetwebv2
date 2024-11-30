<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Check if form is submitted (Add category)
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);

    if (!empty($name) && !empty($description)) {
        try {
            $db = config::getConnexion();

            // Check if the category already exists
            $checkQuery = "SELECT COUNT(*) FROM category WHERE Name = :name";
            $checkStmt = $db->prepare($checkQuery);
            $checkStmt->execute([':name' => $name]);
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                $_SESSION['message'] = 'Error: A category with this name already exists.';
            } else {
                // Insert the new category into the database
                $sql = "INSERT INTO category (Name, Description) VALUES (:name, :description)";
                $query = $db->prepare($sql);
                $query->execute([
                    ':name' => $name,
                    ':description' => $description,
                ]);
                $_SESSION['message'] = 'Category added successfully.';
            }
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error adding category: ' . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = 'Please fill in all fields.';
    }

    // Redirect to DeleteCategory.php after adding the category
    header("Location: DeleteCategory.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
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
                <h2>Add Category</h2>
                <!-- Form submits to the same page to process the request -->
                <form action="AddCategory.php" method="post">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" placeholder="Enter category name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="5" placeholder="Enter category description" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit">Add Category</button>
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
