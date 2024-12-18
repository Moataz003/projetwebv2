<?php
include_once __DIR__.'/../config.php';
require_once __DIR__.'/../models/participation.php';

class ParticipationC
{
    // Method to add a new Participation
    function ajouterParticipation($participation)
    {
        $sql = "INSERT INTO participation (id_user, id_room) VALUES (:id_user, :id_room)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_user' => $participation->getIdUser(),
                'id_room' => $participation->getIdRoom(),
            ]);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }

    // Method to retrieve all Participations
    function afficherParticipations($id)
    {
        $sql = "SELECT * FROM participation WHERE id_user = $id";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    function afficherParticipationsByRoom($id)
    {
        $sql = "SELECT * FROM participation WHERE id_room = $id";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
        // Method to retrieve all Participations
        function afficherParticipationss()
        {
            $sql = "SELECT * FROM participation";
            $db = config::getConnexion();
            try {
                $list = $db->query($sql);
                return $list;
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }

    // Method to delete a Participation by ID
    function supprimerParticipation($id)
    {
        $sql = "DELETE FROM participation WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Method to retrieve a single Participation by ID
    function recupererParticipation($id)
    {
        $sql = "SELECT * FROM participation WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            // Bind both the user and room parameters correctly
            $query->execute(['id' => $id]);
            
            $roomData = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($roomData) {
                // Instantiate and return a Participation object
                $participation = new Participation(
                    $roomData['id'],  
                    $roomData['id_user'], 
                    $roomData['id_room'] 
                );
                return $participation;
            } else {
                return null; // No participation found for the given user and room
            }
        } catch (Exception $e) {
            // Optionally log the error or handle the exception as needed
            echo 'Error: ' . $e->getMessage();
            return null; // Return null in case of an error
        }
    }
    function recupererParticipationByUserAndRoom($user, $room)
    {
        $sql = "SELECT * FROM participation WHERE id_user = :user AND id_room = :room";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            // Bind both the user and room parameters correctly
            $query->execute(['user' => $user, 'room' => $room]);
            
            $roomData = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($roomData) {
                // Instantiate and return a Participation object
                $participation = new Participation(
                    $roomData['id'],  
                    $roomData['id_user'], 
                    $roomData['id_room'] 
                );
                return $participation;
            } else {
                return null; // No participation found for the given user and room
            }
        } catch (Exception $e) {
            // Optionally log the error or handle the exception as needed
            echo 'Error: ' . $e->getMessage();
            return null; // Return null in case of an error
        }
    }
    

    // Method to update an existing Participation by ID
    function modifierParticipation($participation, $id)
    {
        $sql = "UPDATE participation SET 
                id_user = :id_user,
                id_room = :id_room
                WHERE id = :id";

        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_user' => $participation->getIdUser(),
                'id_room' => $participation->getIdRoom(),
                'id' => $id
            ]);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }
}

?>
