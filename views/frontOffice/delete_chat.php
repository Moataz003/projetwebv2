<?php
require_once '../../controllers/chatC.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $user = $_GET['user'];
    $room = $_GET['room'];

    $cC = new ChatC();    
    $cC->supprimerChat($id);
    header("Location: chat.php?room_id=$room&&user_id=$user");
}
?>
