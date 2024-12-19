<?php
include(__DIR__ . '/../model/sponsors.php');

class SponsorController
{
    private $sponsorModel;

    public function __construct()
    {
        $this->sponsorModel = new SponsorModel();
    }

    // Get all sponsors
    public function index()
    {
        $sponsors = $this->sponsorModel->getAllSponsors();
        return json_encode($sponsors);
    }

    // Get a single sponsor by ID
    public function show($id)
    {
        $sponsor = $this->sponsorModel->getSponsorById($id);
        if ($sponsor) {
            return json_encode($sponsor);
        } else {
            return json_encode(['error' => 'Sponsor not found']);
        }
    }

    // Add a new sponsor
    public function store($data)
    {
        $id = $this->sponsorModel->addSponsor($data);
        header('Location: http://localhost/MajdBenAbdallah/view/BACKOFFICE/back/sponsor.php');
        return json_encode(['success' => true, 'id' => $id]);
    }

    // Update an existing sponsor
    public function update($id, $data)
    {
        $this->sponsorModel->updateSponsor($id, $data);
        header('Location: http://localhost/MajdBenAbdallah/view/BACKOFFICE/back/sponsor.php');
        return json_encode(['success' => true]);
    }

    // Delete a sponsor
    public function destroy($id)
    {
        $success = $this->sponsorModel->deleteSponsor($id);
        header('Location: http://localhost/MajdBenAbdallah/view/BACKOFFICE/back/sponsor.php');
        return json_encode(['success' => $success]);
    }
}
?>