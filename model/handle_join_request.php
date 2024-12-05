<?php
// Database configuration
$dbHost = 'localhost';
$dbName = 'events';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Input validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $contact_info = trim($_POST['contact_info']);
    
    // Basic validation
    if (empty($name) || empty($surname) || empty($email)) {
        die("All fields except 'Contact Info' are required.");
    }

    // Insert participant
    $stmt = $pdo->prepare("INSERT INTO participants (event_id, name, surname, email, contact_info) VALUES (:event_id, :name, :surname, :email, :contact_info)");
    $stmt->execute([
        ':event_id' => $event_id,
        ':name' => $name,
        ':surname' => $surname,
        ':email' => $email,
        ':contact_info' => $contact_info,
    ]);

    // Send confirmation email
    $to = $email;
    $subject = "Event Participation Confirmation";
    $message = "Hi $name $surname,\n\nThank you for joining the event. Please wait for our confirmation.\n\nBest regards,\nEvent Team";
    $headers = "From: no-reply@youreventsite.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Registration successful! A confirmation email has been sent to $email.";
    } else {
        echo "Registration successful! But we couldn't send an email.";
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $email = htmlspecialchars($_POST['email']);
    $contact = htmlspecialchars($_POST['contact']);

    // Save to database
    include('config.php');
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $stmt = $pdo->prepare("INSERT INTO registrations (event_id, name, surname, email, contact) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$event_id, $name, $surname, $email, $contact]);

    // Send confirmation email
    $subject = "Event Registration Confirmation";
    $message = "Hello $name,\n\nThank you for registering for the event. Your participation is being reviewed.";
    mail($email, $subject, $message, "From: no-reply@youreventsite.com");

    // Redirect or show success message
    header('Location: thank_you.php');
    exit();
}
?>
