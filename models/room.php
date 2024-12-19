<?php
class Room
{
    private $id;
    private $nom;
    private $nbr_participant;
    private $owner;

    public function __construct($id, $nom, $nbr_participant, $owner)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->nbr_participant = $nbr_participant;
        $this->owner = $owner;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getNbrParticipant()
    {
        return $this->nbr_participant;
    }

    public function setNbrParticipant($nbr_participant)
    {
        $this->nbr_participant = $nbr_participant;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

   
}
?>
