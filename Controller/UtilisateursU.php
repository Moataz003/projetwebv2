<?php
	include 'C:/xampp/htdocs/Motaz/config.php';
	include_once 'C:/xampp/htdocs/Motaz/model/User.php';

	class UtilisateursU {
		function afficherUtilisateurs(){
			$sql="SELECT * FROM users";
			$db = config::getConnexion();
			try{
				$liste = $db->query($sql);
				return $liste;
			}
			catch(Exception $e){
				die('Erreur:'. $e->getMessage());
			}
		}
		function supprimerUtilisateurs($Id_user){
			$sql="DELETE FROM users WHERE Id_user=:Id_user";
			$db = config::getConnexion();
			$req=$db->prepare($sql);
			$req->bindValue(':Id_user', $Id_user);
			try{
				$req->execute();
			}
			catch(Exception $e){
				die('Erreur:'. $e->getMessage());
			}
		}
		function ajouterUtilisateurs($Utilisateurs){
			$sql="INSERT INTO users (Nom, Prenom, Age, Ville, Num_tel, Email, Role , password ,img) 
			VALUES (:Nom, :Prenom, :Age, :Ville, :Num_tel, :Email, :Role ,:password ,:img)";
			$db = config::getConnexion();
			try{
				$query = $db->prepare($sql);
				$query->execute([
					'Nom' => $Utilisateurs->getNom(),
					'Prenom' => $Utilisateurs->getPrenom(),
                    'Age' => $Utilisateurs->getAge(),
                    'Ville' => $Utilisateurs->getVille(),
					'Num_tel' => $Utilisateurs->getNum_tel(),
					'Email' => $Utilisateurs->getEmail(),
					'Role' => $Utilisateurs->getRole(),
					'img' => $Utilisateurs->getImg(),
					'password' => $Utilisateurs->getPassword()
				]);			
			}
			catch (Exception $e){
				echo 'Erreur: '.$e->getMessage();
			}			
		}
		function recupererUtilisateurs($Id_user){
			$sql="SELECT * from users where Id_user=$Id_user";
			$db = config::getConnexion();
			try{
				$query=$db->prepare($sql);
				$query->execute();

				$Utilisateurs=$query->fetch();
				return $Utilisateurs;
			}
			catch (Exception $e){
				die('Erreur: '.$e->getMessage());
			}
		}
		
		function modifierUtilisateurs($Utilisateurs, $Id_user){
			try {
				$db = config::getConnexion();
				$query = $db->prepare(
					'UPDATE users SET 
						Nom= :Nom, 
						Prenom= :Prenom, 
                        Age= :Age, 
                        Ville= :Ville, 
						Num_tel= :Num_tel, 
						Email= :Email, 
						Role= :Role,
						password= :password
					WHERE Id_user= :Id_user'
				);
				$query->execute([
					'Nom' => $Utilisateurs->getNom(),
					'Prenom' => $Utilisateurs->getPrenom(),
                    'Age' => $Utilisateurs->getAge(),
                    'Ville' => $Utilisateurs->getVille(),
					'Num_tel' => $Utilisateurs->getNum_tel(),
					'Email' => $Utilisateurs->getEmail(),
					'Role' => $Utilisateurs->getRole(),
					'Id_user' => $Id_user,
					'password' =>  $Utilisateurs->getPassword()
				]);
				echo $query->rowCount() . " records UPDATED successfully <br>";
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}

		function resetPassword($email,$pass)//updated
		{
			try {
				$db = config::getConnexion();
				$query = $db->prepare(
					'UPDATE users SET 							
							password = :password_user
						WHERE email = :email_user'
				);
				$query->execute([
					'password_user' => $pass,
					'email_user' => $email
				]);
				echo $query->rowCount() . " records UPDATED successfully <br>";
			} catch (PDOException $e) {
				$e->getMessage();
			}
		}

	}
?>