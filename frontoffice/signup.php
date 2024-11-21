<?php

include_once 'C:/xampp/htdocs/Motaz/model/User.php';
include_once 'C:/xampp/htdocs/Motaz/Controller/UtilisateursU.php';
session_start();
if (isset($_SESSION["email"])) {
    if ($_SESSION["role_user"] == "Administrateur")
        header("location:../back/backUser.php");
    else if ($_SESSION["role_user"] == "User")
        header("location:index.php");
}
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
            header('Location:image not uploaded');
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
                    md5($_POST['password'])
                );
                $Utilisateurs->setImg($target_file);
                $UtilisateursU->ajouterUtilisateurs($Utilisateurs);
                
            }
        }
    } else {
        $error = "Missing information";
    }
}

?>
<!DOCTYPE html>
<html lang="en">



<head>
<style>
        .error-message, .error, .success {
            max-width: 250px;
            font-size: 0.85rem;
            margin-top: 5px;
            padding: 2px 5px;
            display: block;
        }

        .error-message, .error {
            color: red;
        }

        .success {
            color: green;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
<style>
    /* Reset and base styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    body {
        min-height: 100vh;
        background: linear-gradient(to bottom, #f0f9ff, #ffffff);
        display: flex;
        flex-direction: column;
    }

    

    /* Main content styles */
    main {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .register-card {
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 32rem;
        transition: box-shadow 0.3s;
    }

    .register-card:hover {
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    .register-header {
        text-align: center;
        margin-bottom: 2rem;
        transition: transform 0.3s;
    }

    .register-header:hover {
        transform: scale(1.05);
    }

    .register-header h2 {
        color: #0c4a6e;
        font-size: 1.875rem;
        margin-bottom: 0.5rem;
    }

    .register-header p {
        color: #0284c7;
        font-size: 0.875rem;
    }

    /* Form styles */
    .form-group {
        margin-bottom: 1.5rem;
        transition: transform 0.3s;
    }

    .form-group:hover {
        transform: translateX(4px);
    }

    .form-label {
        display: block;
        color: #0c4a6e;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-input:focus {
        outline: none;
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.2);
    }

    .password-input {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        color: #0284c7;
        cursor: pointer;
        transition: color 0.3s;
    }

    .password-toggle:hover {
        color: #075985;
    }

    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .register-btn {
        width: 100%;
        padding: 0.75rem;
        background: #0cc0df;
        color: white;
        border: none;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .register-btn:hover {
        background: #0369a1;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Responsive design */
    @media (max-width: 640px) {
        .register-card {
            padding: 1.5rem;
        }
    }
</style>
    <meta charset="utf-8">
    <title>Wajahni</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>Wajahni</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="courses.html" class="nav-item nav-link ">Courses</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="index.html" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->

    <main>
    <div class="register-card">
        <div class="register-header">
            <h2>Create an Account</h2>
            <p>Fill out the form to get started</p>
        </div>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="Nom" class="form-label">Nom</label>
                <input class="form-input" type="text" name="Nom" id="Nom" maxlength="20" placeholder="Nom">
            </div>

            <div class="form-group">
                <label for="Prenom" class="form-label">Prenom</label>
                <input class="form-input" type="text" name="Prenom" id="Prenom" maxlength="20" placeholder="Prenom">
            </div>

            <div class="form-group">
                <label for="Age" class="form-label">Age</label>
                <input class="form-input" type="number" name="Age" id="Age" placeholder="Age">
            </div>

            <div class="form-group">
                <label for="Ville" class="form-label">Ville</label>
                <input class="form-input" type="text" name="Ville" id="Ville" placeholder="Ville">
            </div>

            <div class="form-group">
                <label for="Num_tel" class="form-label">Numéro de Téléphone</label>
                <input class="form-input" type="tel" name="Num_tel" id="Num_tel" placeholder="Téléphone">
            </div>

            <div class="form-group">
                <label for="Email" class="form-label">Email</label>
                <input class="form-input" type="email" name="Email" id="Email" placeholder="Email">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input class="form-input" type="password" name="password" id="password" placeholder="Password">
            </div>

            <div class="form-group">
                <label for="fileToUpload" class="form-label">Profile Picture</label>
                <input class="form-input" type="file" name="fileToUpload" id="fileToUpload">
            </div>

            <input type="hidden" name="Role" id="" value="User">

            <div>
                <button type="submit" class="register-btn">Register</button>
            </div>
        </form>
    </div>
</main>
    
   
  </footer>
  <!-- Footer Start -->
  <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Home</a>
                            <a href="">Cookies</a>
                            <a href="">Help</a>
                            <a href="">FQAs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="validation.js"></script>
</body>

</html>