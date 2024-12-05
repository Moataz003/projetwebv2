<?php

//controle de session (si non connecté => redirect vers login.php)
session_start();

/*if (isset($_SESSION["email"])) {
  if ($_SESSION["role_user"] == "User")
    header("location:../frontoffice/index.php");
} else {
  header("location:../frontoffice/index.php");
}*/

include_once '../../Model/User.php';
include_once '../../Controller/UtilisateursU.php';

$error = "";
// create Utilisateur
$Utilisateurs = null;

// create an instance of the controller
$UtilisateursU = new UtilisateursU();
if (
  isset($_POST["Nom"]) &&
  isset($_POST["Prenom"]) &&
  isset($_POST["Age"]) &&
  isset($_POST["Ville"]) &&
  isset($_POST["Num_tel"]) &&
  isset($_POST["Email"]) &&
  isset($_POST["Role"]) &&
  isset($_POST["password"])
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
    //upload image
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
      // echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      // echo "File is not an image.";
      $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif"
    ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    if ($uploadOk == 0) {
     // header('Location:image not uploaded');
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        $Utilisateurs = new Utilisateurs(
          null,
          $_POST['Nom'],
          $_POST['Prenom'],
          $_POST['Age'],
          $_POST['Ville'],
          $_POST['Num_tel'],
          $_POST['Email'],
          $_POST['Role'],
          $_POST['password']
        );
        $Utilisateurs->setImg($target_file);
        $UtilisateursU->ajouterUtilisateurs($Utilisateurs);
        header('Location:afficherUtilisateurs.php');
      }
    }
  } else {
    $error = "Missing information";
  }
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
              
              <a class="dropdown-item text-danger" href="logout.php">Exit</a>
            </div>
          </li>
        </ul>
      </div>
    </header>

    <section class="content-main" style="max-width: 720px">

      <div class="content-header">
        <h2 class="content-title">Ajouter Utilisateurs</h2>
        <div>
          <a href="#" class="btn btn-primary"> &times; Discard</a>
        </div>
      </div>

      <hr>

      <div id="error">
        <?php echo $error; ?>
      </div>

      <form action="" method="POST" onsubmit="return verif()" enctype="multipart/form-data">

        <div class="mb-4">
          <label for="Nom" class="form-label">Nom: </label>

          <input type="text" name="Nom" id="Nom" maxlength="20" class="form-control">
          <p>
          <div id="errorNom" style="color:red"></div>
          </p>


        </div>
        <div class="mb-4">


          <label for="Prenom">Prenom:</label>
          <input type="text" name="Prenom" id="Prenom" maxlength="20" class="form-control">
          <p>
          <div id="errorPrenom" style="color:red"></div>
          </p>

        </div>
        <div class="mb-4">
          <label for="Age">Age: </label>
          <input type="text" name="Age" id="Age" class="form-control">
          <p>
          <div id="errorAge" style="color:red"></div>
          </p>
        </div>
        <div class="mb-4">
          <label for="Ville">Ville: </label>
          <input type="text" name="Ville" id="Ville" class="form-control">


        </div>

        <div class="mb-4">
          <label for="Num_tel">Num_tel:</label>
          <input type="text" name="Num_tel" id="Num_tel" class="form-control">
          <p>
          <div id="errorNum_tel" style="color:red"></div>
          </p>
        </div>

        <div class="mb-4">
          <label for="Email">Email: </label>
          <input type="Email" name="Email" id="Email" class="form-control">
          <p>
          <div id="errorEmail" style="color:red"></div>
          </p>
        </div>

        <div class="mb-4">
          <label for="password">Password: </label>
          <input type="password" name="password" id="password" class="form-control">
          <p>
          <div id="errorpassword" style="color:red"></div>
          </p>
        </div>

        <div class="mb-4">
          <select class="form-control" id="Role" name="Role">
            <option value="Administrateur">Administrateur</option>
            <option value="User">User</option>
          </select>
        </div>

        <div class="mb-4">
          <label for="fil">photo de profil: </label>
          <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
          <p>
          <div id="errorpassword" style="color:red"></div>
          </p>
        </div>


        <td></td>
        <td>
          <input type="submit" type="button" class="btn btn-primary" style="margin-top:3%;margin-left:5%;border-radius: 10%;" value="Envoyer">
        </td>

      </form>
      <script>
        function verif() {

          var Nom = document.getElementById('Nom').value;
          var Prenom = document.getElementById('Prenom').value;
          var Age = document.getElementById('Age').value;
          var Num_tel = document.getElementById('Num_tel').value;
          var Email = document.getElementById('Email').value;

          var emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

          var errorNom = document.getElementById('errorNom');
          var errorPrenom = document.getElementById('errorPrenom');
          var errorAge = document.getElementById('errorAge');
          var errorNum_tel = document.getElementById('errorNum_tel');
          var errorEmail = document.getElementById('errorEmail');

          if (Nom == "") {
            errorNom.innerHTML = "Oups!Le nom est vide!";
            return false;
          } else
          if (Nom.charAt(0) >= "a" && Nom.charAt(0) <= "z") {
            errorNom.innerHTML = "Le nom doit etre commencé par une lettre majuscule !";
            return false;
          } else {
            errorNom.innerHTML = "";
          }

          if (Prenom == "") {
            errorPrenom.innerHTML = "Oups!Le prenom est vide!";
            return false;
          } else
          if (Prenom.charAt(0) >= "a" && Prenom.charAt(0) <= "z") {
            errorPrenom.innerHTML = "Le prenom doit etre commencé par une lettre majuscule !";
            return false;
          } else {
            errorPrenom.innerHTML = "";
          }


          if (!emailRegex(Email) || Email == "") {
            errorEmail.innerHTML = 'Oups!Entrer un email valide';
            return false;
          } else {
            errorEmail.innerHTML = "";

          }

          if (Age == "") {
            errorAge.innerHTML = "L'age est vide!";
            return false;
          } else
          if (Age <= 18) {
            errorAge.innerHTML = "l'age doit etre superieur à 18 !";
            return false;
          } else {
            errorAge.innerHTML = "";
          }


          if (Num_tel == "") {
            errorNum_tel.innerHTML = "Le numero de telephone est vide!";
            return false;
          } else
          if (Num_tel = 0) {
            errorNum_tel.innerHTML = "Le numero de telephone doit etre superieur à 0 !";
            return false;
          } else {
            errorNum_tel.innerHTML = "";
          }

          /* var aux=Email.substr(Email.indexOf('@'),Email.length)
           if (aux!="@gmail.com")
           {
             errorEmail.innerHTML="Mail se termine par @gmail.com !!";
           }
           else
               {
                   errorEmail.innerHTML="";
               }  */





        }
      </script>
      <br>
      <br>
      <br>
      <br>
      <button><a href="afficherUtilisateurs.php" class="btn btn-primary">Retour à la liste des Utilisateurs</a></button>

      </div> <!-- table-responsive end// -->
      </div> <!-- card-body end// -->
      </div> <!-- card end// -->

    </section> <!-- content-main end// -->
  </main>

  <script>
    if (localStorage.getItem("darkmode")) {
      var body_el = document.body;
      body_el.className += 'dark';
    }
  </script>

  <script src="js/jquery-3.5.0.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script src="js/scriptc619.js?v=1.0"></script>

</body>

<!-- Mirrored from www.ecommerce-admin.com/demo/page-form-product-1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Apr 2022 00:14:44 GMT -->

</html>