<?php
require_once '../../controllers/roomc.php';
require_once '../../controllers/userC.php';
require_once '../../controllers/participationC.php';

$roomC = new RoomC();
$userC = new UserC();
$pC = new ParticipationC();

$room = $roomC->recupererRoom($_GET['id_room']);
$users = $userC->afficherUsers();
$ps = $pC->afficherParticipationss();
$currentuser = $_GET['id_user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>eLEARNING - eLearning HTML Template</title>
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
                <a href="courses.html" class="nav-item nav-link">Courses</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Rooms</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="rooms.php" class="dropdown-item">All rooms</a>
                        <a href="myrooms.php" class="dropdown-item">My rooms</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link active">Contact</a>
            </div>
            <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">All Participants for <?php echo htmlspecialchars($room['nom']); ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Contact/Rooms Display Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Participants</h6>
                <h1 class="mb-5">Participants for <?php echo htmlspecialchars($room['nom']); ?></h1>
                <!-- Create Room Button -->
            </div>
            <div class="row g-4">
    <!-- Dynamically Display Users in the Room -->
    <?php foreach ($users as $user) { 
        // Check if the user is part of the current room
        $isParticipant = false;
        foreach ($ps as $p) {
            if ($user['Id_user'] == $p['id_user'] && $p['id_room'] == $room['id']) {
                $isParticipant = true;
                break; // No need to check further
            }
        }
        
        // Display the user if they are part of the room
        if ($isParticipant) { ?>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card h-100 shadow border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary">
                            <?php echo htmlspecialchars($user['Nom']); ?> <?php echo htmlspecialchars($user['Prenom']); ?>
                        </h5>
                        <?php if ($user['Id_user'] == $room['owner']) { ?>
                            <p class="card-text">
                                Admin
                            </p>
                        <?php } else { ?>
                            <p class="card-text">
                                Participant
                            </p>
                        <?php } ?>
                        <?php if ($currentuser == $room['owner'] && $user['Id_user'] != $room['owner']) { ?>
                            <a href="delete_participation.php?room_id=<?php echo $room['id']; ?>&user_id=<?php echo $user['Id_user']; ?>" class="btn btn-primary">
                                Delete participant
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php }
    } ?>
</div>
        </div>
    </div>
    <!-- Contact/Rooms Display End -->

  

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <!-- Footer content... -->
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
