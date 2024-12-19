<?php
include(__DIR__ . '/../model/events.php');

class EventController
{
    private $eventModel;
    private $pdo;
    private $conn;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->pdo = config::getConnexion(); 
    }


    public function listEvents()
    {
        return $this->eventModel->getAllEvents();
    }

    public function showEvent($id)
    {
        return $this->eventModel->getEventById($id);
    }

    public function createEvent($data)
    {
        $this->eventModel->addEvent($data);
        header('Location: http://localhost/MajdBenAbdallah/view/BACKOFFICE/back/addevent.php');
        exit();
    }

    public function updateEvent($id, $data)
    {
        $this->eventModel->updateEvent($id, $data);
        header('Location: http://localhost/MajdBenAbdallah/view/BACKOFFICE/back/updateevent.php');
        exit();
    }

    public function deleteEvent($id)
    {
        $this->eventModel->deleteEvent($id);
        header('Location: http://localhost/MajdBenAbdallah/view/BACKOFFICE/back/deleteevent.php');
        exit();
    }

    

    public function searchEvents($searchQuery) {
        try {
            $pdo = config::getConnexion();

            // Search query logic
            $sql = "SELECT * FROM events WHERE id LIKE :query OR title LIKE :query";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['query' => '%' . $searchQuery . '%']);

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function sortEventsByDate($order = 'asc') {
        $query = "SELECT * FROM events ORDER BY start_date " . ($order === 'desc' ? 'DESC' : 'ASC');
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


    public function listEventsWithSponsors()
    {
        $query = $this->conn->prepare("SELECT e.*, s.name AS sponsor_name
                                    FROM events e
                                    LEFT JOIN sponsors s ON e.sponsors = s.idsponsors");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getSponsors($id)
    {
        $sponsors = $this->eventModel->getSponsorsByEventId($id);
        return json_encode($sponsors);
    }

}
?>
