<?php
// Start the session
session_start();

?>


<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dashboard</title>

	<link href="./images/wajahni.png" rel="shortcut icon" type="image/x-icon">
	<link href="css/bootstrapf9e3.css?v=1.1" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="fonts/material-icon/css/round.css"/>
	<link href="css/uif9e3.css?v=1.1" rel="stylesheet" type="text/css"/>
	<link href="css/responsivef9e3.css?v=1.1" rel="stylesheet" />
</head>
<body>

<b class="screen-overlay"></b>

<aside class="navbar-aside" id="offcanvas_aside">
<div class="aside-top">
  <a href="index.php" class="brand-wrap">
    <img src="./images/wajahni.png" height="46" class="logo" alt="">
  </a>
  <div>
    <button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i> </button>
  </div>
</div>
<nav>
  <ul class="menu-aside">
    <li class="menu-item active"> 
      <a class="menu-link" href="index.php"> <i class="icon material-icons md-home"></i> 
        <span class="text">Acceuil</span> 
      </a> 
    </li>
    <li class="menu-item has-submenu"> 
      <a class="menu-link" href="#"> <i class="icon material-icons md-person"></i>  
        <span class="text">Utilisateurs</span> 
      </a> 
      <div class="submenu">
      <a href="ajouterUtilisateurs.php">Ajouter Utilisateurs</a>
      <a href="modifierUtilisateurs.php">Modifier Utilisateurs</a>
      <a href="supprimerUtilisateurs.php">Supprimer Utilisateurs</a>
      <a href="afficherUtilisateurs.php">Afficher Utilisateurs</a>
      </div>
    </li>
  </ul>
  <br>
  <br>
</nav>
</aside>
<main class="main-wrap">

<header class="main-header navbar">
	<div class="col-search">
	<div class="col-search">
    <form id="searchForm" class="searchform" method="POST">
        <div class="input-group">
            <input id="searchInput" name="searchTerm" type="text" class="form-control" placeholder="Search by name">
            <button class="btn btn-light bg" type="button" onclick="searchByName()"> <i class="material-icons md-search"></i> </button>
        </div>
    </form>
    <div id="searchResults" class="mt-3"></div>
</div>
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
          <a class="dropdown-item text-danger" href="logout.php">Sortie</a>
        </div>
      </li>
	    </ul> 
  	</div>
</header>

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
	    type: 'line',
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
	    options: {}
	});
</script>
<script>
function searchByName() {
    const query = document.getElementById('searchInput').value;
    const resultsDiv = document.getElementById('searchResults');

    if (query.trim() === '') {
        resultsDiv.innerHTML = "<p>Please enter a search term.</p>";
        return;
    }

    fetch('search.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `searchTerm=${encodeURIComponent(query)}`
    })
    .then(response => response.text())
    .then(data => {
        resultsDiv.innerHTML = data;
    })
    .catch(error => {
        console.error('Error:', error);
        resultsDiv.innerHTML = "<p>Something went wrong. Please try again.</p>";
    });
}
</script>

</body>
</html>

