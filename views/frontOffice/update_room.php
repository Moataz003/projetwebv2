<?php
require_once '../../controllers/roomC.php';
require_once '../../controllers/participationC.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roomName = $_POST['nom'];
    $id = $_POST['room_id'];

    // Create a RoomC object
    $roomC = new RoomC();    
    $room = $roomC->recupererRoom($id);
    $r = new Room($id,$roomName,$room['nbr_participants'],$room['owner']);
    $roomC->modifierRoom($r,$id);
    header('Location: myrooms.php');
}
?>
