<?php
include(__DIR__ . '/../config.php');

class SponsorModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Config::getConnexion();
    }

    // Get all sponsors
    public function getAllSponsors()
    {
        $query = $this->conn->query("SELECT * FROM sponsors");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single sponsor by ID
    public function getSponsorById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM sponsors WHERE idsponsors = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new sponsor
    public function addSponsor($data)
    {
        $query = $this->conn->prepare("INSERT INTO sponsors (name, logo, contact_info) 
                                       VALUES (:name, :logo, :contact_info)");
        $query->execute([
            'name' => $data['name'],
            'logo' => $data['logo'] ?? null,
            'contact_info' => $data['contact_info'] ?? null,
        ]);
        return $this->conn->lastInsertId(); // Return the ID of the newly created sponsor
    }

    // Update an existing sponsor
    public function updateSponsor($id, $data)
    {
        $query = $this->conn->prepare("UPDATE sponsors 
                                       SET name = :name, logo = :logo, contact_info = :contact_info 
                                       WHERE idsponsors = :id");
        $query->execute([
            'id' => $id,
            'name' => $data['name'],
            'logo' => $data['logo'] ?? null,
            'contact_info' => $data['contact_info'] ?? null,
        ]);
    }

    // Delete a sponsor
    public function deleteSponsor($id)
    {
        $query = $this->conn->prepare("DELETE FROM sponsors WHERE idsponsors = :id");
        return $query->execute(['id' => $id]); // Returns true on success, false on failure
    }
}
?>