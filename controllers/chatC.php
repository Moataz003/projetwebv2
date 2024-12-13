<?php
include_once __DIR__.'/../config.php';
require_once __DIR__.'/../models/chat.php';

class ChatC
{
    function ajouterChat($chat)
    {
        // List of inappropriate words
        $inappropriateWords = ["fuck", "bitch", "daddy"];
    
        // Check for inappropriate content in the message
        $contenu = $chat->getContenu();
        foreach ($inappropriateWords as $word) {
            if (stripos($contenu, $word) !== false) { // Case-insensitive search
                echo "Erreur: Le message contient des mots inappropriés.";
                return; // Stop execution if inappropriate words are found
            }
        }
    
        // Prepare SQL query
        $sql = "INSERT INTO chat (contenu, date, id_participation) 
                VALUES (:contenu, :date, :id_participation)";
    
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
    
            // Execute the query with parameters
            $query->execute([
                ':contenu' => $contenu,
                ':date' => $chat->getDate(),
                ':id_participation' => $chat->getIdParticipation(),
            ]);
    
            echo "Message ajouté avec succès.";
        } catch (PDOException $e) {
            // Log the error and display a generic message
            error_log("Database Error: " . $e->getMessage());
            echo "Une erreur est survenue lors de l'ajout du message.";
        }
    }

    function afficherChats($id_room)
    {
        $sql = "SELECT c.* 
                FROM chat c
                JOIN participation p ON c.id_participation = p.id
                WHERE p.id_room = :id_room";
                
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id_room' => $id_room]);
            $list = $query->fetchAll(PDO::FETCH_ASSOC);
            return $list;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function supprimerChat($id)
    {
        $sql = "DELETE FROM chat WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur:' . $e->getMessage());
        }
    }

    function recupererChat($id)
    {
        $sql = "SELECT * FROM chat WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            $chat = $query->fetch(PDO::FETCH_ASSOC);
            return $chat;
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }

    function modifierChat($chat, $id)
    {
        $sql = "UPDATE chat SET 
                contenu = :contenu,
                date = :date,
                id_participation = :id_participation
                WHERE id = :id";

        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'contenu' => $chat->getContenu(),
                'date' => $chat->getDate(),
                'id_participation' => $chat->getIdParticipation(),
                'id' => $id
            ]);
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }
}
?>