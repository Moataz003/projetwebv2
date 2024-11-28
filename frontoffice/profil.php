<?php
session_start();

include_once 'C:/xampp/htdocs/Motaz/controller/UtilisateursU.php';

$utilisateurU = new UtilisateursU();

// Fetch logged-in user details using the session
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
    $userDetails = $utilisateurU->recupererUtilisateurs($id_user);
} else {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedUser = new Utilisateurs(
        $id_user,
        $_POST['Nom'],
        $_POST['Prenom'],
        $_POST['Age'], // Add age to the updated user details
        $_POST['Ville'],
        $_POST['Num_tel'],
        $_POST['Email'],
        $userDetails['Role'], // Keep the same role
        ($_POST['password'] !== '') ? md5($_POST['password']) : $userDetails['password'] // Hash password only if it's changed
    );

    // Handle profile picture upload
    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $targetDir = "uploads/"; // Directory where the images are stored
        $fileName = basename($_FILES['img']['name']);
        $targetFile = $targetDir . $fileName;
        
        // Validate file type (only allow image files)
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            // Check if the file already exists, to avoid overwriting
            if (file_exists($targetFile)) {
                $targetFile = $targetDir . uniqid() . "." . $imageFileType; // Avoid overwriting
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFile)) {
                $updatedUser->setImg($targetFile); // Set the new image path for the user
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Only JPG, JPEG, PNG, & GIF files are allowed.";
        }
    } else {
        // If no image is uploaded, keep the current one
        $updatedUser->setImg($userDetails['img']); 
    }

    // Update the user in the database
    $utilisateurU->modifierUtilisateurs($updatedUser, $id_user);

    // Refresh the user details after update
    $userDetails = $utilisateurU->recupererUtilisateurs($id_user);

    header("Location: profil.php"); // Refresh the page to show updated details
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
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
    <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>Wajahni</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link ">Home</a>
            <a href="about.php" class="nav-item nav-link">About</a>
            <a href="courses.php" class="nav-item nav-link">Courses</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu fade-down m-0">
                    <a href="team.php" class="dropdown-item">Our Team</a>
                    <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                    <a href="404.php" class="dropdown-item">404 Page</a>
                </div>
            </div>
            <a href="contact.php" class="nav-item nav-link">Contact</a>
        </div>

        <!-- User Options -->
        <div class="user_option d-flex align-items-center">
            <?php if (isset($_SESSION['email'])): ?>
                <!-- Profile Image Dropdown -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img 
                            src="<?php echo $_SESSION['img'] ? $_SESSION['img'] : 'img/default-avatar.png'; ?>" 
                            alt="Profile" 
                            class="rounded-circle" 
                            style="width: 40px; height: 40px; object-fit: cover; margin-right: 8px;"
                        >
                        <span>Hello, <?php echo htmlspecialchars($_SESSION['nom_prenom_user']); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profil.php">My Profile</a></li>
                        <li><a class="dropdown-item" href="showSession.php">Show session</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                
                <a href="signup.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">SignUp<i class="fa fa-arrow-right ms-3"></i></a>
                <a href="login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a>

            <?php endif; ?>

            
        </div>
    </div>
</nav>
    <!-- Profile Section -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h3>My Profile</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?php echo $userDetails['img'] ? $userDetails['img'] : 'img/default-avatar.png'; ?>" 
                             alt="Profile Picture" 
                             class="rounded-circle mb-3" 
                             style="width: 150px; height: 150px; object-fit: cover;">
                        <h4><?php echo htmlspecialchars($userDetails['Nom'] . ' ' . $userDetails['Prenom']); ?></h4>
                        <p><?php echo htmlspecialchars($userDetails['Email']); ?></p>
                        <p>Phone: <?php echo htmlspecialchars($userDetails['Num_tel']); ?></p>
                        <p>City: <?php echo htmlspecialchars($userDetails['Ville']); ?></p>
                        <p>Age: <?php echo htmlspecialchars($userDetails['Age']); ?></p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            Edit Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="Nom" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="Nom" name="Nom" value="<?php echo htmlspecialchars($userDetails['Nom']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Prenom" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="Prenom" name="Prenom" value="<?php echo htmlspecialchars($userDetails['Prenom']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="Email" name="Email" value="<?php echo htmlspecialchars($userDetails['Email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Num_tel" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="Num_tel" name="Num_tel" value="<?php echo htmlspecialchars($userDetails['Num_tel']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Ville" class="form-label">City</label>
                            <input type="text" class="form-control" id="Ville" name="Ville" value="<?php echo htmlspecialchars($userDetails['Ville']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="Age" name="Age" value="<?php echo htmlspecialchars($userDetails['Age']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if not changing">
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="img" name="img">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  

     <!-- JavaScript Libraries -->
     <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="edit.js"></script>
    
</body>

</html>
