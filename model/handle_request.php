<?php
include(__DIR__ . '/../controller/events controller.php');
//include(__DIR__ . '/../controller/sponsor controller.php');

$controller = new EventController();
//$controller1 = new SponsorController();

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
            /*case 'add_sponsor':
                $controller1 = new Sponsor();
                $controller1->add($_POST['name'], $_FILES['logo']['name'], $_POST['contact_info']);
                move_uploaded_file($_FILES['logo']['tmp_name'], "asset/images/" . $_FILES['logo']['name']);
                break;
            case 'link_sponsor':
                $controller1 = new Sponsor();
                $controller1->linkSponsorToEvent($_POST['event_id'], $_POST['sponsor_id']);
                header("Location:http://localhost/MajdBenAbdallah/view/BACKOFFICE/back/index.php");
                break;*/
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
