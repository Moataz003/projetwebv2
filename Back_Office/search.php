<?php
// Include your database connection
require_once 'C:\xampp\htdocs\Motaz\config.php';

// Check if the search term is provided
if (isset($_POST['searchTerm']) && !empty($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];

    try {
        $pdo = config::getConnexion();

        // Use the correct column name "Nom"
        $stmt = $pdo->prepare("SELECT * FROM users WHERE Nom LIKE :searchTerm");
        $stmt->execute(['searchTerm' => "%$searchTerm%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<ul>";
            foreach ($results as $row) {
                echo "<li>{$row['Nom']} {$row['Prenom']} - {$row['Email']}</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No results found for '$searchTerm'.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>No search term provided!</p>";
}
?>
