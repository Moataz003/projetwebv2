<?php
// Start session
session_start();
require_once 'C:/xampp/htdocs/Motaz/Controller/UtilisateursU.php';

// Fetch sorted users
$utilisateurController = new UtilisateursU();
$sortOption = $_GET['sort'] ?? 'alphabetic'; // Default sort is alphabetic
$users = $utilisateurController->getUsersSorted($sortOption);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Tri des utilisateurs</title>
  <link href=".\images\wajahni.png" rel="shortcut icon" type="image/x-icon">
  <link href="asset/css/bootstrapf9e3.css?v=1.1" rel="stylesheet" type="text/css"/>
  <link href="asset/css/uif9e3.css?v=1.1" rel="stylesheet" type="text/css"/>
  <link href="asset/css/responsivef9e3.css?v=1.1" rel="stylesheet" />
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
  </div>

  <nav>
    <ul class="menu-aside">
      <li class="menu-item"> 
        <a class="menu-link" href="index.php"> <i class="icon material-icons md-home"></i> 
          <span class="text">Accueil</span> 
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





      <li class="menu-item active"> 
        <a class="menu-link" href="tri.php"> <i class="icon material-icons md-sort"></i> 
          <span class="text">Trier Utilisateurs</span> 
        </a> 
      </li>
    </ul>
    <hr>
  </nav>
</aside>

<main class="main-wrap">
  <header class="main-header navbar">
    <div class="col-search">
      <form class="searchform">
        <div class="input-group">
          <input list="search_terms" type="text" class="form-control" placeholder="Rechercher">
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
        <li class="nav-item dropdown">
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
      <h3 class="mb-4">Trier les Utilisateurs</h3>
      <form method="GET" class="mb-3">
        <div class="row">
          <div class="col-md-4">
            <select name="sort" class="form-select" onchange="this.form.submit()">
              <option value="alphabetic" <?= $sortOption == 'alphabetic' ? 'selected' : '' ?>>Ordre alphabétique</option>
              <option value="age" <?= $sortOption == 'age' ? 'selected' : '' ?>>Par âge</option>
            </select>
          </div>
        </div>
      </form>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Âge</th>
            <th>Ville</th>
            <th>Rôle</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['Nom']) ?></td>
              <td><?= htmlspecialchars($user['Email']) ?></td>
              <td><?= htmlspecialchars($user['Age']) ?></td>
              <td><?= htmlspecialchars($user['Ville']) ?></td>
              <td><?= htmlspecialchars($user['Role']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<script type="text/javascript">
  if(localStorage.getItem("darkmode")){
    document.body.classList.add('dark');
  }
</script>
<script src="asset/js/jquery-3.5.0.min.js"></script>
<script src="asset/js/bootstrap.bundle.min.js"></script>
</body>
</html>
