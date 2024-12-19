<?php
require_once '../../controllers/roomC.php';
require_once '../../controllers/participationC.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roomName = $_POST['nom'];
    $current = $_POST['currentuser'];

    // Create a RoomC object
    $roomC = new RoomC();
    $participationC = new ParticipationC();
    
    // Check if the room already exists
    if ($roomC->searchRoomByName($roomName)) {
        $room = $roomC->recupererRoombyName($roomName);
        echo "Before update: " . $room->getNbrParticipant(); // Debugging
        $room->setNbrParticipant($room->getNbrParticipant() + 1);
        echo "After update: " . $room->getNbrParticipant(); // Debugging
        $roomC->modifierRoom($room, $room->getId());
        $participant = new Participation(null, $current, $room->getId());
        $participationC->ajouterParticipation($participant);
        echo "A room with this name already exists!";
        header('Location: rooms.php');
    }
     else {
        // If room doesn't exist, proceed to create the room
        $room = new Room(null, $roomName, 1, $current);
        $roomC->ajouterRoom($room);
        $roomn = $roomC->recupererRoombyName($roomName);
        $participant = new Participation(null,$current,$roomn->getId());
        $participationC->ajouterParticipation($participant);
        header('Location: rooms.php');
    }
}
?>
