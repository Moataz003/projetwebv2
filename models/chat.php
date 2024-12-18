<?php
class Chat
{
    private $id;
    private $contenu;
    private $date;
    private $id_participation;

    public function __construct($id, $contenu, $date, $id_participation)
    {
        $this->id = $id;
        $this->contenu = $contenu;
        $this->date = $date;
        $this->id_participation = $id_participation;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getIdParticipation()
    {
        return $this->id_participation;
    }

    public function setIdParticipation($id_participation)
    {
        $this->id_participation = $id_participation;
    }
}
?>
