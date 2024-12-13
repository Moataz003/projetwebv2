<?php
class Participation
{
    private $id;
    private $id_user;
    private $id_room;

    public function __construct($id, $id_user, $id_room)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_room = $id_room;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getIdRoom()
    {
        return $this->id_room;
    }

    public function setIdRoom($id_room)
    {
        $this->id_room = $id_room;
    }
}
?>
