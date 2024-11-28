<?php 
session_start();

if (isset($_SESSION["email"])) {
    switch ($_SESSION["role_user"]) {
        case "Administrateur":
            header("Location: ../Back_Office/afficherUtilisateurs.php");
            break;
        case "User":
            header("Location: index.php");
            break;
        default:
            session_destroy(); 
    }
}

$con = mysqli_connect('localhost', 'root', '', 'motaz');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = "";
if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = md5($_POST["password_user"]); 

   
    $stmt = $con->prepare("SELECT * FROM users WHERE Email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['email'] = $email;
        while ($row = $result->fetch_assoc()) {
            $_SESSION['nom_prenom_user'] = $row['Nom'] . " " . $row['Prenom'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['tel_user'] = $row['Num_tel'];
            $_SESSION['id_user'] = $row['Id_user'];
            $_SESSION['role_user'] = $row['Role'];
            $_SESSION['img'] = $row['img'];
        }

        if ($_SESSION["role_user"] == "Administrateur") {
            header("Location: ../Back_Office/afficherUtilisateurs.php");
        } else if ($_SESSION["role_user"] == "User") {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "Incorrect email or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">



<head>
<style>
         {
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

        

        .register-btn {
            background: #0cc0df;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .register-btn:hover {
            background: #0369a1;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            50% { transform: translateY(-30px); }
        }

        .login-card {
            background: rgb(252, 252, 252);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 28rem;
            transition: box-shadow 0.3s;
        }

        .login-card:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
            transition: transform 0.3s;
        }

        .login-header:hover {
            transform: scale(1.05);
        }

        .login-header h2 {
            color: #0c4a6e;
            font-size: 1.875rem;
            margin-bottom: 0.5rem;
        }

        .login-header p {
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

        .forgot-link {
            color: #0284c7;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: #075985;
        }

        .submit-btn {
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

        .submit-btn:hover {
            background: #0369a1;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Social login styles */
        .divider {
            text-align: center;
            position: relative;
            margin: 1.5rem 0;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            background: white;
            padding: 0 0.5rem;
            color: #0284c7;
            font-size: 0.875rem;
            position: relative;
        }

        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            background: white;
            color: #0284c7;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .social-btn:hover {
            background: #f0f9ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .social-btn img {
            width: 20px;
            height: 20px;
            margin-right: 0.5rem;
        }

        /* Footer styles */
        footer {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            padding: 1rem 1.5rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .copyright {
            color: #0284c7;
            font-size: 0.875rem;
        }

        /* Responsive design */
        @media (max-width: 640px) {
            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .footer-links {
                justify-content: center;
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


    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>Wajahni</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link">Home</a>
            <a href="about.html" class="nav-item nav-link">About</a>
            <a href="courses.html" class="nav-item nav-link">Courses</a>
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

        <?php if (isset($_SESSION['email'])): ?>
            <!-- User Profile Image -->
            <div class="dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <!-- Display user image or placeholder -->
                    <img 
                        src="<?php echo $_SESSION['img'] ? $_SESSION['img'] : './img/deffault.png'; ?>" 
                        alt="Profile" 
                        class="rounded-circle" 
                        style="width: 40px; height: 40px; object-fit: cover;"
                    >
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="profil.php">My Profile</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <!-- Sign Up Button for Guests -->
            <a href="signup.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">SignUp<i class="fa fa-arrow-right ms-3"></i></a>
        <?php endif; ?>
    </div>
</nav>

<!-- Navbar End -->


    <main>
        <div class="login-card">
            <div class="login-header">
                <h2>Welcome back</h2>
                <p>Please enter your credentials to continue</p>
            </div>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-input" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password_user" class="form-input" placeholder="Enter your password" required>
                </div>

                <div class="form-footer">
                <div class="form-group">
                  <a href="forgotpassword.php" class="forgot-password-link">Forgot Password?</a>
                  </div>
                </div>

                <button type="submit" class="submit-btn">Log in</button>
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