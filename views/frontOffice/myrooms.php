<?php
require_once '../../controllers/roomc.php';
require_once '../../controllers/participationc.php';
$roomC = new RoomC();
$currentuser = 2;
$participationC = new ParticipationC();
$listeRooms = $roomC->afficherRooms();
$listeParticipation = $participationC->afficherParticipations($currentuser);

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
                    <h1 class="display-3 text-white animated slideInDown">My Rooms</h1>
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
            <h6 class="section-title bg-white text-center text-primary px-3">Rooms</h6>
            <h1 class="mb-5">Explore My Rooms</h1>
        </div>
        <div class="row g-4">
            <?php 
            $displayedRooms = []; // Array to track displayed room ids
            foreach ($listeRooms as $room) { 
                // Skip room if it has already been displayed
                if (in_array($room['id'], $displayedRooms)) {
                    continue;
                }

                // Mark room as displayed
                $displayedRooms[] = $room['id'];
                
                // Check if there is a participation for this room
                foreach ($listeParticipation as $p) {
                    if($p['id_room'] == $room['id']) {
            ?>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="card h-100 shadow border-0">
                            <div class="card-body">
                                <div class="dots-container">
                                    <div class="dots" onclick="toggleMenu(<?php echo $room['id']; ?>)">
                                        <span class="dot"></span>
                                        <span class="dot"></span>
                                        <span class="dot"></span>
                                    </div>
                                    <div class="btn-menu" id="btn-menu-<?php echo $room['id']; ?>" style="display: none;">
                                        <?php if($room['owner'] == $currentuser){ ?>
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoomModal" data-room-id="<?php echo $room['id']; ?>" data-room-name="<?php echo $room['nom']; ?>">
                                                <i class="fas fa-pencil-alt"></i> Update
                                            </a>
                                            <a href="delete_room.php?room_id=<?php echo $room['id']; ?>" class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                        <?php } else { ?>
                                            <p class="card-text" style="color:green">You are a Participant</p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <h5 class="card-title text-primary">
                                    Room name : <?php echo htmlspecialchars($room['nom']); ?>
                                </h5>
                                <p class="card-text">
                                    Number of participants : <?php echo htmlspecialchars($room['nbr_participants']); ?>
                                </p>
                                
                                <a href="chat.php?room_id=<?php echo $room['id']; ?>&&user_id=<?php echo $currentuser ?>" class="btn btn-primary">
                                    <i class="fas fa-comments"></i> Go to Chat
                                </a>
                            </div>
                        </div>
                    </div>
            <?php 
                    break; // Break the loop once the room is found in the participation list
                    }
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="createRoomModal" tabindex="-1" aria-labelledby="createRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRoomModalLabel">Update Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="update_room.php" method="POST">
                    <!-- Hidden Input for Room ID -->
                    <input type="hidden" class="form-control" id="room-id" name="room_id" required>
                    
                    <div class="mb-3">
                        <label for="roomName" class="form-label">Room Name</label>
                        <input type="text" class="form-control" id="roomName" name="nom" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Create Room Modal End -->
<!-- Contact/Rooms Display End -->    

<style>
/* Add modern animation for the room cards */
.wow.fadeInUp {
    animation-name: fadeInUp;
    animation-duration: 1s;
    animation-timing-function: ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Style for the buttons */
.card-body .btn {
    margin: 5px;
    padding: 12px 25px;
    font-size: 14px;
    text-transform: uppercase;
    border-radius: 25px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-body .btn:hover {
    background-color: #0d6efd;
    color: white;
    transform: scale(1.05);
}

.card-body .btn i {
    font-size: 16px;
}

/* Styling for the three dots menu */
.dots-container {
    position: absolute;
    top: 10px;
    right: 10px; /* Align to the top right */
    cursor: pointer;
}

.dots {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    gap: 3px; /* Reduced gap between dots */
}

.dot {
    width: 6px; /* Smaller size for dots */
    height: 6px;
    margin: 3px;
    border-radius: 50%;
    background-color: #333;
    transition: all 0.3s ease;
}

.dot:hover {
    background-color: #0d6efd;
    transform: scale(1.4); /* Slightly grow the dots on hover */
}

.btn-menu {
    display: flex;
    flex-direction: column;
    gap: 12px;
    position: absolute;
    top: 30px;
    right: 10px; /* Align the menu to the right */
    background-color: white;
    padding: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.btn-menu a {
    padding: 12px 20px;
    border-radius: 8px;
    text-align: left;
    font-size: 14px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-menu a:hover {
    background-color: #0d6efd;
    color: white;
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .dots-container {
        position: static;
        margin-bottom: 10px;
    }
}
</style>

<script>
// JavaScript function to toggle the visibility of the button menu
function toggleMenu(roomId) {
    var menu = document.getElementById("btn-menu-" + roomId);
    if (menu.style.display === "none" || menu.style.display === "") {
        menu.style.display = "flex"; // Show the menu
        setTimeout(function() { menu.style.opacity = 1; }, 0); // Fade-in effect
    } else {
        menu.style.opacity = 0;
        setTimeout(function() {
            menu.style.display = "none"; // Hide the menu
        }, 300); // Delay to let the fade-out animation complete
    }
}
</script>


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
    <script>
        document.getElementById('createRoomModal').addEventListener('show.bs.modal', function (event) {
    // Get the button that triggered the modal
    const button = event.relatedTarget;
    
    // Extract data from the data-* attributes
    const roomId = button.getAttribute('data-room-id');
    const roomName = button.getAttribute('data-room-name');
    
    // Populate the modal form fields
    document.getElementById('room-id').value = roomId;
    document.getElementById('roomName').value = roomName;
});

    </script>
</body>

</html>
