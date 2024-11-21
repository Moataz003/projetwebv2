<?php
	class Utilisateurs{
		private $Id_user=null;
		private $Nom=null;
		private $Prenom=null;
		private $Age=null;
		private $Ville=null;
       	private $Num_tel=null;
        private $Email=null;
		private $Role=null;
		private $password=null;
		private $img = null;

		function __construct($Id_user, $Nom, $Prenom, $Age, $Ville, $Num_tel, $Email, $Role,$password){
			$this->Id_user=$Id_user;
			$this->Nom=$Nom;
			$this->Prenom=$Prenom;
			$this->Age=$Age;
			$this->Ville=$Ville;
            $this->Num_tel=$Num_tel;
            $this->Email=$Email;
            $this->Role=$Role;
			$this->password=$password;
		}
		function getId_user(){
			return $this->Id_user;
		}
		function getNom(){
			return $this->Nom;
		}
		function getPrenom(){
			return $this->Prenom;
		}
		function getAge(){
			return $this->Age;
		}
		function getVille(){
			return $this->Ville;
		}
		function getNum_tel(){
			return $this->Num_tel;
		}
        function getEmail(){
			return $this->Email;
		}
        function getRole(){
			return $this->Role;
		}
		function setNom(string $Nom){
			$this->Nom=$Nom;
		}
		function setPrenom(string $Prenom){
			$this->Prenom=$Prenom;
		}
		function setAge(int $Age){
			$this->Age=$Age;
		}
		function setVille(string $Ville){
			$this->Ville=$Ville;
		}
		function setNum_tel(int $Num_tel){
			$this->Num_tel=$Num_tel;
		}
        function setEmail(string $Email){
			$this->Email=$Email;
		}
        function setRole(string $Role){
			$this->Role=$Role;
		}
		

		/**
		 * Get the value of password
		 */ 
		public function getPassword()
		{
				return $this->password;
		}

		/**
		 * Set the value of password
		 *
		 * @return  self
		 */ 
		public function setPassword($password)
		{
				$this->password = $password;

				return $this;
		}

		/**
		 * Get the value of img
		 */ 
		public function getImg()
		{
				return $this->img;
		}

		/**
		 * Set the value of img
		 *
		 * @return  self
		 */ 
		public function setImg($img)
		{
				$this->img = $img;

				return $this;
		}
	}


?>