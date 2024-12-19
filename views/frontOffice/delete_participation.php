<?php
require_once '../../controllers/roomC.php';
require_once '../../controllers/participationC.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $roomid = $_GET['room_id'];
    $user = $_GET['user_id'];
    $current = $_GET['current'];

    // Create a RoomC object
    $roomC = new RoomC();
    $pC = new ParticipationC();

    $room = $roomC->recupererRoom($roomid);
    $r = new Room($roomid,$room['nom'],$room['nbr_participants']-1,$room['owner']);
    $roomC->modifierRoom($r,$roomid);
    $p = $pC->recupererParticipationByUserAndRoom($user,$roomid);
    $pC->supprimerParticipation($p->getId());
    header("Location: participants.php?id_room=$roomid&&id_user=$current");
}
?>