<?php
include(__DIR__ . '/../controller/sponsors controller.php');


$controller = new SponsorController();

// Assuming you're using a simple routing mechanism
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $controller = new SponsorController();
    echo $controller->show($_GET['id']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new SponsorController();
    echo $controller->store($_POST);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    parse_str(file_get_contents("php://input"), $data);
    $controller = new SponsorController();
    echo $controller->update($_GET['id'], $data);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $controller = new SponsorController();
    echo $controller->destroy($_GET['id']);
} else {
    $controller = new SponsorController();
    echo $controller->index();
}
?>