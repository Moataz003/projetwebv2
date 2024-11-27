<?php
session_start();

require_once 'C:\xampp\htdocs\ProjetWeb\config.php';

// Check if form is submitted (Add category)
if (isset($_POST['submit'])) {
  // Sanitize and validate inputs
  $name = htmlspecialchars($_POST['name']);
  $description = htmlspecialchars($_POST['description']);

  // Check if inputs are not empty
  if (!empty($name) && !empty($description)) {
      try {
          
          $db = config::getConnexion();

          
          $checkQuery = "SELECT COUNT(*) FROM category WHERE Name = :name";
          $checkStmt = $db->prepare($checkQuery);
          $checkStmt->execute([':name' => $name]);
          $count = $checkStmt->fetchColumn();

          if ($count > 0) {
            
            $_SESSION['message'] = 'Error: A category with this name already exists.';
          } else {
              
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

  
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}


if (isset($_POST['delete'])) {
  $categoryId = $_POST['category_id'];

  
  if (!empty($categoryId)) {
      
      $sql = "DELETE FROM category WHERE CategoryID = :category_id";

      try {
          
          $db = config::getConnexion();

          
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


try {
    $db = config::getConnexion();
    $sql = "SELECT CategoryID, Name FROM category";
    $query = $db->prepare($sql);
    $query->execute();
    $categories = $query->fetchAll();
} catch (Exception $e) {
    $_SESSION['message'] = 'Error fetching categories: ' . $e->getMessage();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Categories</title>
  <link rel="stylesheet" href="./css/StylesAddCategory.css">
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="./images/wajahni2.png" alt="Logo" class="logo">
      <nav>
        <a href="#">Dashboard</a>
        <a href="#">Add course</a>
        <a href="#">Edit course</a>
        <a href="#">Settings</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="header">
        <div class="profile">Admin</div>
      </header>

      <!-- Add Category Form -->
      <div class="form-container">
        <h2>Add Category</h2>
        <form action="" method="post">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter category name" >
          </div>
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" placeholder="Enter category description"></textarea>
          </div>
          <div class="form-group">
            <button type="submit" name="submit">Add Category</button>
          </div>
        </form>
      </div>

      <!-- Delete Category Form -->
      <div class="form-container">
        <h2>Delete Category</h2>
        <form action="" method="post">
          <div class="form-group">
            <label for="category_id">Select Category:</label>
            <select id="category_id" name="category_id" required>
              <option value="" disabled selected>Select a category</option>
              <?php foreach ($categories as $category): ?>
                <option value="<?= $category['CategoryID'] ?>"><?= htmlspecialchars($category['Name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" name="delete">Delete Category</button>
          </div>
        </form>
      </div>
    </main>
  </div>

  <?php if (isset($_SESSION['message'])): ?>
    <script>
      window.alert("<?php echo $_SESSION['message']; ?>");
    </script>
    <?php 
      unset($_SESSION['message']); 
    ?>
  <?php endif; ?>

  <script src="/ProjetWeb/VIEW/js/ControleSaisiCreate.js"></script>
</body>
</html>
