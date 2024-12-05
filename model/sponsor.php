<?php
include(__DIR__ . '/../config.php');


class Sponsor {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getAll() {
        $sql = "SELECT * FROM sponsor";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function add($data) {
        $sql = "INSERT INTO sponsor (name, logo) VALUES (:name, :logo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }
}
?>
