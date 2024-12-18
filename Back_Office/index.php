<?php
// Start the session
session_start();
require_once 'C:/xampp/htdocs/Motaz/Controller/UtilisateursU.php';

// Fetch statistics
$utilisateurController = new UtilisateursU();
$stats = $utilisateurController->getStatistics();
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
        <a href="search.php">Rechercher</a>
       
		</div>
		</li>

    <li class="menu-item "> 
        <a class="menu-link" href="tri.php"> <i class="icon material-icons md-sort"></i> 
          <span class="text">Trier Utilisateurs</span> 
        </a> 
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


	<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Total Users</h5>
              <p class="display-4"><?= $stats['total_users'] ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Most Common City</h5>
              <p class="display-5"><?= $stats['most_common_city']['Ville'] ?></p>
              <p><?= $stats['most_common_city']['count'] ?> users</p>
            </div>
          </div>
        </div>
        
      </div>

      <div class="row mt-4">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">Users by Role</div>
            <div class="card-body">
              <canvas id="usersByRoleChart"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">City Distribution</div>
            <div class="card-body">
              <canvas id="cityDistributionChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
 


</main>

<script src="asset/js/jquery-3.5.0.min.js"></script>
<script src="asset/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
  const usersByRoleCtx = document.getElementById('usersByRoleChart').getContext('2d');
  const usersByRoleChart = new Chart(usersByRoleCtx, {
    type: 'pie',
    data: {
      labels: <?= json_encode(array_column($stats['users_by_role'], 'Role')) ?>,
      datasets: [{
        label: 'Users by Role',
        data: <?= json_encode(array_column($stats['users_by_role'], 'count')) ?>,
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
      }]
    },
    options: { responsive: true, legend: { position: 'bottom' } }
  });

  const cityDistributionCtx = document.getElementById('cityDistributionChart').getContext('2d');
  const cityDistributionChart = new Chart(cityDistributionCtx, {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_column($stats['city_distribution'], 'Ville')) ?>,
      datasets: [{
        label: 'Users per City',
        data: <?= json_encode(array_column($stats['city_distribution'], 'count')) ?>,
        backgroundColor: '#36A2EB',
      }]
    },
    options: { responsive: true, scales: { xAxes: [{ barPercentage: 0.5 }], yAxes: [{ ticks: { beginAtZero: true } }] } }
  });
</script>
</body>
</html>