<?php
include_once __DIR__.'/../config.php';
require_once __DIR__.'/../models/room.php';

class RoomC
{
    // Ajouter une salle
    public function ajouterRoom($room)
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

    // Afficher toutes les salles
    public function afficherRooms()
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

    // Supprimer une salle
    public function supprimerRoom($id)
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

    // Récupérer une salle par son ID
    public function recupererRoom($id)
    {
        $sql = "SELECT * FROM room WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            $room = $query->fetch(PDO::FETCH_ASSOC);
            return $room;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // Récupérer une salle par son nom
    public function recupererRoombyName($name)
    {
        $sql = "SELECT * FROM room WHERE nom = :name";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['name' => $name]);
            $roomData = $query->fetch(PDO::FETCH_ASSOC);

            if ($roomData) {
                $room = new Room(
                    $roomData['id'], 
                    $roomData['nom'], 
                    $roomData['nbr_participants'], 
                    $roomData['owner']
                );
                return $room;
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    // Modifier une salle
    public function modifierRoom($room, $id)
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

    // Chercher une salle par son nom
    public function searchRoomByName($roomName)
    {
        $db = config::getConnexion();
        $sql = "SELECT * FROM room WHERE nom = :roomName"; 
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':roomName', $roomName);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? true : false;
    }

    // Compter le nombre total de salles avec ou sans recherche
    public function countRoomsWithSearch($search = '')
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM room";
            if (!empty($search)) {
                $sql .= " WHERE nom LIKE :search";
            }
            $db = config::getConnexion();
            $stmt = $db->prepare($sql);

            if (!empty($search)) {
                $searchTerm = "%" . $search . "%";
                $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return 0;
        }
    }

    // Récupérer les salles filtrées et triées
    public function fetchFilteredSortedRooms($search = '', $sort = 'ASC', $limit = 4, $offset = 0)
    {
        try {
            $sql = "SELECT * FROM room";
            if (!empty($search)) {
                $sql .= " WHERE nom LIKE :search";
            }
            $sql .= " ORDER BY nbr_participants $sort LIMIT :limit OFFSET :offset";

            $db = config::getConnexion();
            $stmt = $db->prepare($sql);

            if (!empty($search)) {
                $searchTerm = "%" . $search . "%";
                $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            }

            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }
}
?>
