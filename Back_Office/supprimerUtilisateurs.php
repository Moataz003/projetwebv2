<?php
//controle de session (si non connecté => redirect vers login.php)
session_start();
if (isset($_SESSION["email"]))
{
	 if ($_SESSION["role_user"] == "User")
	header("location:../frontoffice/index.php") ; 
} else {
	header("location:../frontoffice/index.php") ; 
}


include '../../Controller/UtilisateursU.php';
	$UtilisateursU=new UtilisateursU();
	$UtilisateursU->supprimerUtilisateurs($_GET["Id_user"]);
	header('Location:afficherUtilisateurs.php');
?>