<?php
// Start session and include required files
session_start();
include '../../Controller/UtilisateursU.php';
include_once "C:/xampp/htdocs/Motaz/config.php";

$UtilisateursU = new UtilisateursU();
$results = [];

// Process search form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $criteria = [
        'Nom' => $_POST['Nom'] ?? '',
        'Age' => $_POST['Age'] ?? '',
        'Ville' => $_POST['Ville'] ?? '',
        'Role' => $_POST['Role'] ?? ''
    ];
    $results = $UtilisateursU->rechercherUtilisateurs($criteria);
}
?>
<!DOCTYPE HTML>
<html lang="en">
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
      <img src=".\images\wajahni.png" height="46" class="logo" alt="Dashboard Template">
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
        <datalist id="search_terms"></datalist>
      </form>
    </div>
    <div class="col-nav">
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
          <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#"> 
            <img class="img-xs rounded-circle" src="<?php echo $_SESSION['img']; ?>" alt="User">
          </a>
          <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="..\frontoffice\profil.php">Profile</a>
            <a class="dropdown-item text-danger" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </header>

  <section class="content-main">
    <div class="content-header">
      <h2 class="content-title">Search Users</h2>
    </div>
    <div class="row" style="justify-content: center;">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">Search Form</strong>
          </div>
          <div class="card-body">
            <form method="POST" class="form-inline">
              <div class="form-group mx-sm-3 mb-2">
                <label for="Nom" class="sr-only">Nom:</label>
                <input type="text" name="Nom" id="Nom" class="form-control" placeholder="Name">
              </div>
              <div class="form-group mx-sm-3 mb-2">
                <label for="Age" class="sr-only">Age:</label>
                <input type="number" name="Age" id="Age" class="form-control" placeholder="Age">
              </div>
              <div class="form-group mx-sm-3 mb-2">
                <label for="Ville" class="sr-only">Ville:</label>
                <input type="text" name="Ville" id="Ville" class="form-control" placeholder="City">
              </div>
              <div class="form-group mx-sm-3 mb-2">
                <label for="Role" class="sr-only">Role:</label>
                <select name="Role" id="Role" class="form-control">
                  <option value="">All</option>
                  <option value="Administrateur">Admin</option>
                  <option value="user">User</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>

            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
              <div class="mt-4">
                <?php if ($results): ?>
                  <ul>
                    <?php foreach ($results as $row): ?>
                      <li><?php echo "{$row['Nom']} {$row['Prenom']} - {$row['Ville']} - {$row['Role']}"; ?></li>
                    <?php endforeach; ?>
                  </ul>
                <?php else: ?>
                  <p>No results found.</p>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<script src="asset/js/jquery-3.5.0.min.js"></script>
<script src="asset/js/bootstrap.bundle.min.js"></script>
<script src="asset/js/scriptc619.js?v=1.0"></script>
</body>
</html>
