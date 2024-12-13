<?php
include_once __DIR__.'/../config.php';
require_once __DIR__.'/../models/user.php';

class UserC
{
    function afficherUsers()
    {
        $sql = "SELECT * FROM users";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    function recupererUser($id)
    {
        $sql = "SELECT * FROM users WHERE Id_user = :id";
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
}
?>
