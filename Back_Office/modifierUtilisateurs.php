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

include_once '../../Controller/UtilisateursU.php';
$error = "";

// create Utilisateurs
$Utilisateurs = null;

// create an instance of the coantroller
$UtilisateursU = new UtilisateursU();
if (
  isset($_POST["Nom"]) &&
  isset($_POST["Prenom"]) &&
  isset($_POST["Age"]) &&
  isset($_POST["Ville"]) &&
  isset($_POST["Num_tel"]) &&
  isset($_POST["Email"]) &&
  isset($_POST["Role"])
) {
  if (
    !empty($_POST['Nom']) &&
    !empty($_POST["Prenom"]) &&
    !empty($_POST["Age"]) &&
    !empty($_POST["Ville"]) &&
    !empty($_POST["Num_tel"]) &&
    !empty($_POST["Email"]) &&
    !empty($_POST["Role"])
  ) {
    $Utilisateurs = new Utilisateurs(
      NULL,
      $_POST['Nom'],
      $_POST['Prenom'],
      $_POST['Age'],
      $_POST['Ville'],
      $_POST['Num_tel'],
      $_POST['Email'],
      $_POST['Role'],
      md5($_POST['password'])
    );
    $UtilisateursU->modifierUtilisateurs($Utilisateurs, $_POST["Id_user"]);
    header('Location:afficherUtilisateurs.php');
  } else
    $error = "Missing information";
}
?>
<!DOCTYPE HTML>
<html lang="en">

<!-- Mirrored from www.ecommerce-admin.com/demo/page-form-product-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 00:14:44 GMT -->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Gestion Utilisateurs</title>

  <link href=".\images\wajahni.png" rel="shortcut icon" type="image/x-icon">

  <link href="css/bootstrapf9e3.css?v=1.1" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="fonts/material-icon/css/round.css" />

  <!-- custom style -->
  <link href="css/uif9e3.css?v=1.1" rel="stylesheet" type="text/css" />
  <link href="css/responsivef9e3.css?v=1.1" rel="stylesheet" />

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
            <option value="Products">
            <option value="New orders">
            <option value="Apple iphone">
            <option value="Ahmed Hassan">
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
              
              <a class="dropdown-item text-danger" href="logout.php">Exit</a>
            </div>
          </li>
        </ul>
      </div>
    </header>

    <section class="content-main" style="max-width: 720px">

      <div class="content-header">
        <h2 class="content-title">modifier Utilisateurs</h2>
        <div>
          <a href="#" class="btn btn-primary"> &times; Discard</a>
        </div>
      </div>


      <hr>

      <div id="error">
        <?php echo $error; ?>
      </div>



      <?php
      if (isset($_POST['Id_user'])) {
        $Utilisateurs = $UtilisateursU->recupererUtilisateurs($_POST['Id_user']);

      ?>

        <br>
        <br>
        <br>


        <form action="" method="POST">
        <input type="hidden" value="<?php echo $_POST['Id_user']; ?>" name="Id_user">
          <div class="mb-4">
            <label for="Nom">Nom: </label>
            <input type="text" name="Nom" id="Nom" value="<?php echo $Utilisateurs['Nom']; ?>" maxlength="20" class="form-control">

          </div>

          <div class="mb-4">
            <label for="Prenom">Prenom: </label>
            <input type="text" name="Prenom" id="Prenom" value="<?php echo $Utilisateurs['Prenom']; ?>" maxlength="20" class="form-control">

          </div>

          <div class="mb-4">
            <label for="Age">Age: </label>
            <input type="text" name="Age" value="<?php echo $Utilisateurs['Age']; ?>" id="Age" class="form-control" disabled>
          </div>


          <div class="mb-4">
            <label for="Ville">Ville: </label>
            <input type="text" name="Ville" value="<?php echo $Utilisateurs['Ville']; ?>" id="Ville" class="form-control" disabled>
          </div>


          <div class="mb-4">
            <label for="Num_tel">Num_tel:</label>
            <input type="text" name="Num_tel" id="Num_tel" value="<?php echo $Utilisateurs['Num_tel']; ?>" id="Num_tel" class="form-control" disabled>
          </div>

          <div class="mb-4">
    <label for="Email">Email:</label>
    <input type="email" name="Email" id="Email" value="<?php echo $Utilisateurs['Email']; ?>" class="form-control" disabled>
</div>

<div class="mb-4">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" value="<?php echo $Utilisateurs['password']; ?>" class="form-control" disabled>
</div>

          <div class="mb-4">
            <label for="Role">Role: </label>
            <input type="text" name="Role" id="Role" value="<?php echo $Utilisateurs['Role']; ?>" class="form-control">
          </div>



          <td></td>
          <td>
            <input type="submit" class="btn btn-primary" value="Modifier">
          </td>
          </tr>

        </form>
      <?php
      }
      ?>

      <br>
      <br>
      <br>

      <button><a href="afficherUtilisateurs.php" class="btn btn-primary">Retour à la liste des Utilisateurs</a></button>



      </div> <!-- table-responsive end// -->
      </div> <!-- card-body end// -->
      </div> <!-- card end// -->

    </section> <!-- content-main end// -->
  </main>

  <script type="text/javascript">
    if (localStorage.getItem("darkmode")) {
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
        datasets: [{
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