<?php
include(__DIR__ . '/../config.php');

class EventModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = Config::getConnexion();
    }

    // Retrieve all events
    public function getAllEvents()
    {
        $query = $this->conn->query("SELECT * FROM events");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve a single event by ID
    public function getEventById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM events WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new event
    public function addEvent($data)
    {
        $query = $this->conn->prepare("INSERT INTO events (title, description, location, start_date, end_date, status, image) 
                                       VALUES (:title, :description, :location, :start_date, :end_date, :status, :image)");
        $query->execute([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'location' => $data['location'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'],
            'image' => $data['image'] ?? null,
            //'sponsors' => $data['sponsors'] ?? null,
        ]);
        return $this->conn->lastInsertId();
    }

    // Update an existing event
    public function updateEvent($id, $data)
    {
        $query = $this->conn->prepare("UPDATE events 
                                       SET title = :title, description = :description, location = :location, 
                                           start_date = :start_date, end_date = :end_date, status = :status, 
                                           image = :image
                                       WHERE id = :id");
        $query->execute([
            'id' => $id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'location' => $data['location'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'],
            'image' => $data['image'] ?? null,
            'sponsors' => $data['sponsors'] ?? null,
        ]);
    }

    // Delete an event
    public function deleteEvent($id)
    {
        $query = $this->conn->prepare("DELETE FROM events WHERE id = :id");
        $query->execute(['id' => $id]);
    }

    // Get sponsors by event ID
   public function getSponsorsByEventId($id)
    {
        $query = $this->conn->prepare("SELECT s.* FROM sponsors s 
                                        JOIN events e ON s.idsponsors = e.sponsors 
                                        WHERE e.id = :eventId");
        $query->execute(['eventId' => $id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
