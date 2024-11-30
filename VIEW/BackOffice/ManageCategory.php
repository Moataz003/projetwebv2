<?php
session_start();
require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Number of records per page
$limit = 6;

// Get the current page from URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Handle category deletion
if (isset($_POST['delete'])) {
    $categoryId = $_POST['category_id'];

    if (!empty($categoryId)) {
        try {
            $db = config::getConnexion();

            $sql = "DELETE FROM category WHERE CategoryID = :category_id";
            $query = $db->prepare($sql);
            $query->execute([':category_id' => $categoryId]);

            $_SESSION['message'] = 'Category deleted successfully.';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Error deleting category: ' . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = 'Please select a category to delete.';
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch the total number of categories
try {
    $db = config::getConnexion();
    $sql = "SELECT COUNT(*) FROM category";
    $query = $db->prepare($sql);
    $query->execute();
    $totalCategories = $query->fetchColumn();
} catch (Exception $e) {
    $_SESSION['message'] = 'Error fetching categories: ' . $e->getMessage();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch categories for the current page
try {
    $sql = "SELECT CategoryID, Name, Description FROM category LIMIT :limit OFFSET :offset";
    $query = $db->prepare($sql);
    $query->bindParam(':limit', $limit, PDO::PARAM_INT);
    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $categories = $query->fetchAll();
} catch (Exception $e) {
    $_SESSION['message'] = 'Error fetching categories: ' . $e->getMessage();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Calculate the total number of pages
$totalPages = ceil($totalCategories / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="./css/CategoryManagement.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <img src="./images/wajahni2.png" alt="Logo" class="logo">
            <nav>
                <a href="#">Dashboard </a>
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

            <!-- Category Table -->
            <div class="form-container">
                <h2>Categories</h2>
                <form action="AddCategory.php">
                    <button type="submit" class="delete-button">Add Category</button>
                </form>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category ID</th>
                            <th style="text-align: center; padding-left: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= htmlspecialchars($category['Name']) ?></td>
                            <td><?= htmlspecialchars($category['Description']) ?></td>
                            <td><?= htmlspecialchars($category['CategoryID']) ?></td>
                            <td style="text-align: right;">
                                <!-- Delete Button -->
                                <form action="" method="post" style="display: inline-block;">
                                    <input type="hidden" name="category_id" value="<?= $category['CategoryID'] ?>">
                                    <button type="submit" class="delete-button" name="delete">Delete</button>
                                </form>

                                <!-- Edit Button -->
                                <form action="EditCategory.php" method="get" style="display: inline-block;">
                                    <input type="hidden" name="category_id" value="<?= $category['CategoryID'] ?>">
                                    <button type="submit" class="edit-button">Edit</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                    <?php endfor; ?>
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
