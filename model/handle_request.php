<?php
include(__DIR__ . '/../controller/events controller.php');


$controller = new EventController();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $controller->createEvent($_POST);
                break;
            case 'update':
                $controller->updateEvent($_POST['id'], $_POST);
                break;
            case 'delete':
                $controller->deleteEvent($_POST['id']);
                break;
            
        }
    } else {
        echo "Error: Action not specified in POST request.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] === 'list') {
        $events = $controller->listEvents();
        echo json_encode($events);
    }
}

?>


