<?php
include_once __DIR__.'/../config.php';
require_once __DIR__.'/../models/room.php';

class RoomC
{
    function ajouterRoom($room)
    {
        $sql = "INSERT INTO room (nom, nbr_participants, owner) 
                VALUES (:nom, :nbr_participants, :owner)";

        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $room->getNom(),
                'nbr_participants' => $room->getNbrParticipant(),
                'owner' => $room->getOwner()
            ]);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }

    function afficherRooms()
    {
        $sql = "SELECT * FROM room";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    

    function supprimerRoom($id)
    {
        $sql = "DELETE FROM room WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur:' . $e->getMessage());
        }
    }

    function recupererRoom($id)
    {
        $sql = "SELECT * FROM room WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            $room = $query->fetch(PDO::FETCH_ASSOC);
            return $room;
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    function recupererRoombyName($name)
    {
        $sql = "SELECT * FROM room WHERE nom = :name";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['name' => $name]);
            $roomData = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($roomData) {
                // Instantiate and return a Room object
                $room = new Room(
                    $roomData['id'],   // Assuming 'id' is the field name
                    $roomData['nom'],  // Assuming 'nom' is the field name
                    $roomData['nbr_participants'], // Assuming 'status' is the field name
                    $roomData['owner'] // Assuming 'owner' is the field name
                );
                return $room;
            } else {
                return null; // No room found
            }
        } catch (Exception $e) {
            // Optionally log the error or handle the exception as needed
            echo $e->getMessage();
            return null; // Return null in case of an error
        }
    }
    

    function modifierRoom($room, $id)
    {
        $sql = "UPDATE room SET 
                nom = :nom,
                nbr_participants = :nbr_participants,
                owner = :owner
                WHERE id = :id";

        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $room->getNom(),
                'nbr_participants' => $room->getNbrParticipant(),
                'owner' => $room->getOwner(),
                'id' => $id
            ]);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }
    public function searchRoomByName($roomName) {
        $db = config::getConnexion();
        $sql = "SELECT * FROM room WHERE nom = :roomName"; 
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':roomName', $roomName);
        $stmt->execute();

        // Fetch results
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // If room exists, return true, else false
        return $result ? true : false;
    }

    public function countRoomsWithSearch($search)
    {
        $sql = "SELECT COUNT(*) AS total FROM room WHERE 
                nom LIKE :search OR 
                nbr_participants LIKE :search";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([':search' => '%' . $search . '%']);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    public function fetchFilteredSortedRooms($search, $sort, $limit, $offset)
    {
        $sql = "SELECT * FROM room WHERE 
                nom LIKE :search OR 
                nbr_participants LIKE :search
                ORDER BY nbr_participants $sort
                LIMIT :limit OFFSET :offset";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>