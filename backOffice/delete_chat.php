<?php
require_once '../../controllers/chatC.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $room = $_GET['room'];

    $cC = new ChatC();    
    $cC->supprimerChat($id);
    header("Location: chats.php?id=$room");
}
?>
