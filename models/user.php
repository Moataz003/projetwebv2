<?php
class User
{
    private $id_user;
    private $nom;
    private $prenom;
    private $age;
    private $ville;
    private $num_tel;
    private $email;
    private $role;
    private $password;
    private $img;

    // Constructor
    public function __construct($id_user, $nom, $prenom, $age, $ville, $num_tel, $email, $role, $password, $img)
    {
        $this->id_user = $id_user;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->age = $age;
        $this->ville = $ville;
        $this->num_tel = $num_tel;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
        $this->img = $img;
    }

    // Getters and Setters
    public function getIdUser()
    {
        return $this->id_user;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    public function getNumTel()
    {
        return $this->num_tel;
    }

    public function setNumTel($num_tel)
    {
        $this->num_tel = $num_tel;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;
    }
}
?>
