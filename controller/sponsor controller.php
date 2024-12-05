<?php
include(__DIR__ . '/../model/sponsor.php');


class SponsorController {
    private $model;

    public function __construct() {
        $this->model = new Sponsor();
    }

    public function list() {
        $sponsors = $this->model->getAll();
    }

    public function add($data) {
        $this->model->add($data);
        header('Location: Location: http://localhost/MajdBenAbdallah/view/BACKOFFICE/add-sponsor.php');
    }
}
?>
