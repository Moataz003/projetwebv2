<?php
/*require_once '../../controllers/chatC.php';
require_once '../../models/chat.php';

$chatC = new ChatC();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_message']) && isset($_POST['chat_id'])) {
    // Récupérer le message mis à jour et l'ID du chat
    $newMessage = $_POST['new_message'];
    $chatId = $_POST['chat_id'];
    $date = date('Y-m-d H:i:s'); // La date actuelle

    // Créer une instance de Chat avec les nouvelles données
    $chat = new Chat($chatId, $newMessage, $date, null);

    // Appeler la méthode de mise à jour du message
    $chatC->modifierChat($chat, $chatId);

    // Rediriger vers la page du chat avec les paramètres appropriés
    header("Location: chat.php?room_id=$room&&user_id=$user");
   // header('Location: chat.php?room_id=' . $_GET['room_id'] . '&user_id=' . $_GET['user_id']);
    exit; // Terminer le script pour éviter toute exécution supplémentaire
}
?>
<?php*/
require_once '../../controllers/chatC.php';
require_once '../../models/chat.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_message']) && isset($_POST['chat_id'])) {
    $newMessage = $_POST['new_message'];
    $chatId = $_POST['chat_id'];
    $date = date('Y-m-d H:i:s'); // Current date and time
    $user = $_GET['user']; // User ID from GET request
    $room = $_GET['room']; // Room ID from GET request

    // Create a Chat object
    $chat = new Chat($chatId, $newMessage, $date, null);

    // Instantiate the controller
    $chatC = new ChatC();

    // Create a Chat object $chat = $chatC->recupererChat($id);
    // Call the updateChat function
    $chatC->modifierChat($chat);

    // Redirect back to the chat page
    header("Location: chat.php?room_id=$room&&user_id=$user");
    exit;
}
?>
