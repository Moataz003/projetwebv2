<?php
include(__DIR__ . '/../model/events.php');

class EventController
{
    private $eventModel;
    private $pdo;

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

    public function listEventsWithSponsors()
{
    $sql = "SELECT e.*, GROUP_CONCAT(s.name SEPARATOR ', ') AS sponsors
            FROM event e
            LEFT JOIN event_sponsor es ON e.id = es.event_id
            LEFT JOIN sponsor s ON es.sponsor_id = s.id
            GROUP BY e.id";
    return $this->pdo->query($sql)->fetchAll();
}

}
?>
