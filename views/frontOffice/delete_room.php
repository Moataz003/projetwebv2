<?php
require_once '../../controllers/roomC.php';
require_once '../../controllers/participationC.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['room_id'];

    // Create a RoomC object
    $roomC = new RoomC();    
    $roomC->supprimerRoom($id);
    header('Location: myrooms.php');
}
?>
