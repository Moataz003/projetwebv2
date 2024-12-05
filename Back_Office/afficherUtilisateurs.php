<?php
//controle de session (si non connecté => redirect vers login.php)
session_start();

	/*if (isset($_SESSION["email"]))
	{
		 if ($_SESSION["role_user"] == "User")
		header("location:../frontoffice/index.php") ; 
	} else {
		header("location:../frontoffice/index.php") ; 
	}*/


	include '../../Controller/UtilisateursU.php';
	include_once "C:/xampp/htdocs/Motaz/config.php";
	$UtilisateursU=new UtilisateursU();
	$listeUtilisateurs=$UtilisateursU->afficherUtilisateurs(); 
?>
<!DOCTYPE HTML>
<html lang="en">

<!-- Mirrored from www.ecommerce-admin.com/demo/page-index-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 00:14:32 GMT -->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>dashboard</title>

  <link href=".\images\wajahni.png" rel="shortcut icon" type="image/x-icon">

  <link href="asset/css/bootstrapf9e3.css?v=1.1" rel="stylesheet" type="text/css"/>

  <!-- custom style -->
  <link href="asset/css/uif9e3.css?v=1.1" rel="stylesheet" type="text/css"/>
  <link href="asset/css/responsivef9e3.css?v=1.1" rel="stylesheet" />

  <!-- iconfont -->
  <link rel="stylesheet" href="fonts/material-icon/css/round.css"/>

</head>
<body>

<b class="screen-overlay"></b>

<aside class="navbar-aside" id="offcanvas_aside">
<div class="aside-top">
  <a href="index.php" class="brand-wrap">
    <img src=".\images\wajahni.png" height="46" class="logo" alt="Ecommerce dashboard template">
  </a>
  <div>
    <button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i> </button>
  </div>
</div> <!-- aside-top.// -->

<nav>
  <ul class="menu-aside">
    <li class="menu-item active"> 
      <a class="menu-link" href="index.php"> <i class="icon material-icons md-home"></i> 
        <span class="text">Acceuil</span> 
      </a> 
    </li>
   
   
    
	
    
   
 
    <li class="menu-item has-submenu"> 
      <a class="menu-link" href="afficherUtilisateurs.php"> <i class="icon material-icons md-person"></i>  
        <span class="text">Utilisateurs</span> 
      </a> 
	  <div class="submenu">
        <a href="ajouterUtilisateurs.php">Ajouter Utilisateurs</a>
        <a href="modifierUtilisateurs.php">Modifier Utilisateurs</a>
        <a href="supprimerUtilisateurs.php">Supprimer Utilisateurs</a>
       
		</div>
		</li>
    
   
  </ul>
  <hr>
 
  <br>
  <br>
</nav>
</aside>

<main class="main-wrap">
	<header class="main-header navbar">
		<div class="col-search">
			<form class="searchform">
				<div class="input-group">
				  <input list="search_terms" type="text" class="form-control" placeholder="Search term">
				  <button class="btn btn-light bg" type="button"> <i class="material-icons md-search"></i> </button>
				</div>
				<datalist id="search_terms">
				</datalist>
			</form>
		</div>
		<div class="col-nav">
     <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> <i class="md-28 material-icons md-menu"></i> </button>
     <ul class="nav">
      <li class="nav-item">
          <a class="nav-link btn-icon" onclick="darkmode(this)" title="Dark mode" href="#"> <i class="material-icons md-nights_stay"></i> </a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn-icon" href="#"> <i class="material-icons md-notifications_active"></i> </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"> English </a>
      </li>
      <li class="dropdown nav-item">
        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#"> <img class="img-xs rounded-circle" src="<?php echo $_SESSION['img'] ?>" alt="User"></a>
        <div class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="..\frontoffice\profil.php">Profil</a>
          
          <a class="dropdown-item text-danger" href="logout.php">Sortie</a>
        </div>
      </li>
    </ul> 
  </div>
	</header>

<section class="content-main">
	<div class="content-header">
		<h2 class="content-title"> Dashboard </h2>
		
	</div>
	<div class="row" style="justify-content: center;">
                    <div class="col-lg-12" >
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"></strong>
                            </div>
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        <div class="card-title">
	  <a href="ajouterUtilisateurs.php">  <button type="button" class="btn btn-primary"  style="margin-top:3%;margin-left:5%;border-radius: 10%;">Ajouter</button></a>
		<center><h1>Liste des Utilisateurs</h1></center>
		<br>
		<br>
		<table class="table align-items-center table-flush">
    <tr>
        <th>Photo de Profil</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Modifier</th>
        <th>Supprimer</th>
    </tr>
    <?php
    foreach ($listeUtilisateurs as $Utilisateurs) {
    ?>
    <tr>
        <!-- Profile Picture -->
        <td><img class="img-xs rounded-circle" src="<?php echo $Utilisateurs['img']; ?>" alt="User"></td>

        <!-- Name -->
        <td><?php echo $Utilisateurs['Nom']; ?></td>

        <!-- Surname -->
        <td><?php echo $Utilisateurs['Prenom']; ?></td>

        <!-- Email -->
        <td><?php echo $Utilisateurs['Email']; ?></td>

        <!-- Edit Button -->
        <td>
            <form method="POST" action="modifierUtilisateurs.php">
                <input type="submit" name="Modifier" class="btn btn-primary" value="Modifier">
                <input type="hidden" value="<?php echo $Utilisateurs['Id_user']; ?>" name="Id_user">
            </form>
        </td>

        <!-- Delete Button -->
        <td>
            <a href="supprimerUtilisateurs.php?Id_user=<?php echo $Utilisateurs['Id_user']; ?>">
                <button type="button" class="btn btn-primary">Supprimer</button>
            </a>
        </td>
    </tr>
    <?php
    }
    ?>
</table>
	

		</div> <!-- table-responsive end// -->
          </div> <!-- card-body end// -->
    </div> <!-- card end// -->
	</div>     		

</section> <!-- content-main end// -->
</main>

<script type="text/javascript">
	if(localStorage.getItem("darkmode")){
		var body_el = document.body;
		body_el.className += 'dark';
	}
</script>

<script src="asset/js/jquery-3.5.0.min.js"></script>
<script src="asset/js/bootstrap.bundle.min.js"></script>

<!-- ChartJS files-->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<!-- Custom JS -->
<script src="asset/js/scriptc619.js?v=1.0" type="text/javascript"></script>

<!-- ChartJS customize-->
<script>
	var ctx = document.getElementById('myChart').getContext('2d');
	var chart = new Chart(ctx, {
	    // The type of chart we want to create
	    type: 'line',

	    // The data for our dataset
	    data: {
	        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
	        datasets: [
	        {
	            label: 'Sales',
	            backgroundColor: 'rgb(44, 120, 220)',
	            borderColor: 'rgb(44, 120, 220)',
	            data: [18, 17, 4, 3, 2, 20, 25, 31, 25, 22, 20, 9]
	        },
	        {
	            label: 'Visitors',
	            backgroundColor: 'rgb(180, 200, 230)',
	            borderColor: 'rgb(180, 200, 230)',
	            data: [40, 20, 17, 9, 23, 35, 39, 30, 34, 25, 27, 17]
	        } 

	        ]
	    },

	    // Configuration options go here
	    options: {}
	});
</script>

</body>

<!-- Mirrored from www.ecommerce-admin.com/demo/page-index-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 00:14:39 GMT -->
</html>
