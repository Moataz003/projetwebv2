<?php
require_once '../../controllers/chatC.php';
require_once '../../controllers/participationC.php';
require_once '../../controllers/roomC.php';
require_once '../../controllers/userC.php';

$chatC = new ChatC();
$participationC = new ParticipationC();
$roomC = new RoomC();
$userC = new UserC();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    if ($message != '') {
        $date = date('Y-m-d H:i:s');
        $id_participation = $participationC->recupererParticipationByUserAndRoom($_GET['user_id'], $_GET['room_id'])->getId();
        $chat = new Chat(null, $message, $date, $id_participation);
        $chatC->ajouterChat($chat);
        $message = '';
    }
}

$chats = $chatC->afficherChats($_GET['room_id']);
$room = $roomC->recupererRoom($_GET['room_id']);
$currentuser = $_GET['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chat Room</title>
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
    <style>
.msg {
    display: block;
    margin-bottom: 10px;
    padding: 10px;
    background-color: #f1f1f1;
    border-radius: 5px;
    width: fit-content;
    max-width: 80%; /* Adjust the maximum width of messages */
    clear: both; /* Ensures each message starts on a new line */
}

.right-align {
    text-align: right;
    margin-left: auto; /* Push the message to the right */
    background-color: #d1ecf1; /* Optional: different color for right-aligned messages */
}

.left-align {
    text-align: left;
    margin-right: auto; /* Push the message to the left */
    background-color: #f8d7da; /* Optional: different color for left-aligned messages */
}

    </style>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>wajahni</h2>
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
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Chat Room: <?= htmlspecialchars($room['nom']); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Chat Room</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Chat Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Chat</h6>
            <h1 class="mb-5">Welcome to the Chat Room</h1>
            <a href="participants.php?id_room=<?php echo $_GET['room_id']; ?>&&id_user=<?php echo $_GET['user_id']; ?>&&current=<?php echo $currentuser; ?>" class="btn btn-primary mb-4">
                Show participants
            </a>
        </div>
        <div class="row g-4">
            <div class="col-12">
                <div id="chat-messages" class="mb-4">
                    <?php foreach ($chats as $chat) :
                        if ($participationC->recupererParticipationByUserAndRoom($_GET['user_id'], $_GET['room_id'])->getId() == $chat['id_participation']) {
                            $user = $userC->recupererUser($_GET['user_id']);
                            $username = $user['Nom'] . " " . $user['Prenom'];
                            $role = ($participationC->recupererParticipation($chat['id_participation'])->getIdUser() == $room['owner']) ? 'Admin' : 'Participant';
                    ?>
                            <!-- Message (right-aligned) -->
                            <div class="msg-container right-align wow fadeInUp" data-wow-delay="0.2s">
                                <div class="msg <?php echo strtolower($role); ?>">
                                    <div class="msg-header">
                                        <span class="msg-username" onmouseover="showRole(this)" onmouseout="hideRole(this)"><?php echo $username; ?></span>
                                        <span class="msg-time"><?php echo htmlspecialchars($chat['date']); ?></span>
                                    </div>
                                    <div class="msg-body">
                                        <?= htmlspecialchars($chat['contenu']); ?>
                                    </div>
                                    <div class="msg-options">
                                        <!-- Buttons -->
                                        <button class="btn btn-light btn-sm options-btn" onclick="toggleOptions(<?php echo $chat['id']; ?>)">...</button>
                                        <div id="options-<?php echo $chat['id']; ?>" class="delete-options" style="display:none;">
                                            <a href="delete_chat.php?id=<?php echo $chat["id"]; ?>&&user=<?php echo $_GET['user_id']; ?>&&room=<?php echo $_GET['room_id']; ?>" class="btn btn-danger btn-sm mb-1">Delete</a>
                                            <button class="btn btn-success btn-sm edit-btn" onclick="editMessage(<?php echo $chat['id']; ?>)">Edit</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Form -->
                                <form method="POST" id="edit-form-<?php echo $chat['id']; ?>" action="update_chat.php?room_id=<?php echo $_GET['room_id']; ?>&user_id=<?php echo $_GET['user_id']; ?>" style="display:none;">
                                    <textarea name="new_message" class="form-control mb-2" id="edit-message-<?php echo $chat['id']; ?>"><?= htmlspecialchars($chat['contenu']); ?></textarea>
                                    <input type="hidden" name="chat_id" value="<?php echo $chat['id']; ?>">
                                    <div class="edit-buttons">
                                    <a href="update_chat.php?id=<?php echo $chat["id"]; ?>&&user=<?php echo $_GET['user_id']; ?>&&room=<?php echo $_GET['room_id']; ?>" class="btn btn-danger btn-sm mb-1">save</a>
                                     <!--   <button type="submit" class="btn btn-primary btn-sm" onclick="modifierChat(<?php// echo $chat['id']; ?>)">Save</button>-->
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="cancelEdit(<?php echo $chat['id']; ?>)">Cancel</button>
                                    </div>
                                </form>
                            </div>
                    <?php
                        } else {
                            $user = $userC->recupererUser($participationC->recupererParticipation($chat['id_participation'])->getIdUser());
                            $username = $user['Nom'] . " " . $user['Prenom'];
                            $role = ($participationC->recupererParticipation($chat['id_participation'])->getIdUser() == $room['owner']) ? 'Admin' : 'Participant';
                    ?>
                            <!-- Message (left-aligned) -->
                            <div class="msg-container left-align wow fadeInUp" data-wow-delay="0.2s">
                                <div class="msg <?php echo strtolower($role); ?>">
                                    <div class="msg-header">
                                        <span class="msg-username" onmouseover="showRole(this)" onmouseout="hideRole(this)"><?php echo $username; ?></span>
                                        <span class="msg-time"><?php echo htmlspecialchars($chat['date']); ?></span>
                                    </div>
                                    <div class="msg-body">
                                        <?= htmlspecialchars($chat['contenu']); ?>
                                    </div>
                                    <div class="msg-role">
                                        <em><?php echo $role; ?></em>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    endforeach; ?>
                </div>

                <!-- Send Message Form -->
                <form method="POST">
                    <textarea name="message" placeholder="Type your message..." class="form-control mb-3" required></textarea><br>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Additional CSS Styles -->
<style>
    .edit-buttons {
        display: flex;
        gap: 10px;
        margin-top: 5px;
    }

    .edit-buttons .btn {
        flex: 1;
    }

    .msg-options {
        margin-top: 5px;
    }

    .options-btn {
        border-radius: 5px;
    }

    .delete-options .btn {
        display: block;
        margin: 5px 0;
    }

    .edit-btn {
        background-color: #28a745;
        color: #fff;
        font-weight: bold;
    }

    .edit-btn:hover {
        background-color: #218838;
        color: #fff;
    }
</style>

<!-- JavaScript for Toggle Options -->
<script>
    function toggleOptions(id) {
        const options = document.getElementById('options-' + id);
        options.style.display = options.style.display === 'none' ? 'block' : 'none';
    }

    function editMessage(id) {
        const form = document.getElementById('edit-form-' + id);
        const options = document.getElementById('options-' + id);
        form.style.display = 'block';
        options.style.display = 'none';
    }

    function cancelEdit(id) {
        const form = document.getElementById('edit-form-' + id);
        form.style.display = 'none';
    }
</script>
 
<!-- Chat Section End -->

<!-- CSS Styles for Modern Chat Messages -->
<style>
    .msg-container {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 20px;
        width: 100%;
        animation: fadeInMessage 0.6s ease-in-out;
    }

    .right-align {
        justify-content: flex-end;
    }

    .left-align {
        justify-content: flex-start;
    }

    .msg {
        max-width: 75%;
        padding: 12px 20px;
        border-radius: 25px;
        margin: 5px;
        background-color: #f7f7f7;
        position: relative;
        width: fit-content;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    .msg-header {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
    }

    .msg-body {
        margin-top: 10px;
        font-size: 16px;
        color: #333;
    }

    .msg-username {
        font-weight: bold;
        color: #007bff;
        position: relative;
        cursor: pointer;
    }

    .msg-time {
        font-size: 12px;
        color: #888;
    }

    .msg-username:hover + .msg-role {
        display: block;
    }

    .msg-role {
        position: absolute;
        top: 0;
        right: 0;
        font-size: 12px;
        color: #888;
        display: none;
    }

    .msg-options {
        position: absolute;
        right: 5px;
        bottom: 5px;
        display: flex;
        flex-direction: column;
    }

    .msg-options button {
        background: transparent;
        border: none;
        cursor: pointer;
        color: #888;
        font-size: 16px;
        transition: all 0.3s ease;
        margin-bottom: 5px;
    }

    .msg-options button:hover {
        color: #555;
    }

    .delete-options {
        display: none;
        position: absolute;
        right: 0;
        bottom: 20px;
        background-color: #fff;
        padding: 5px;
        border-radius: 5px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        font-size: 12px;
    }

    .delete-options a {
        text-decoration: none;
        color: #f00;
        font-size: 14px;
        font-weight: bold;
    }

    .msg.admin {
        background-color: #e3f2fd;
        border-color: #007bff;
    }

    .msg.participant {
        background-color: #e8f5e9;
        border-color: #28a745;
    }

    /* Hover styles for the role */
    .msg-username:hover + .msg-role {
        display: block;
    }

    /* Animation */
    @keyframes fadeInMessage {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Animation for WOW.js */
    .wow {
        visibility: hidden;
    }

    .wow.fadeInUp {
        animation: fadeInUp 0.8s forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .msg {
            max-width: 100%;
        }
    }
</style>

<!-- JS for Toggle Delete Option -->
<script>
    function toggleDelete(chatId) {
        var deleteOptions = document.getElementById('delete-' + chatId);
        if (deleteOptions.style.display === 'none' || deleteOptions.style.display === '') {
            deleteOptions.style.display = 'block';
        } else {
            deleteOptions.style.display = 'none';
        }
    }

    // Show role when hovering over username
    function showRole(element) {
        var role = element.nextElementSibling; // next sibling is the role
        role.style.display = 'block';
    }

    function hideRole(element) {
        var role = element.nextElementSibling; // next sibling is the role
        role.style.display = 'none';
    }
</script>

<!-- JS for Animation (if you don't have WOW.js already) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
    new WOW().init();
</script>

    <!-- Chat Section End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <!-- Footer content -->
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
        // Fonction pour envoyer un message
    function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();

    // Liste de mots inappropriés
    const inappropriateWords = ["fuck", "bitch", "daddy",kill"];  
    
    // Vérifier si le message contient des mots inappropriés
    for (let word of inappropriateWords) {
        if (message.toLowerCase().includes(word.toLowerCase())) {
            alert("Votre message contient des mots inappropriés. Veuillez les supprimer.");
            return;  // Ne pas envoyer le message
        }
    }

    if (message && currentDiscussionId) {
        fetch('', {
            method: 'POST',
            body: new URLSearchParams({
                'sender': 'Your username',  // Remplacer par le nom de l'utilisateur connecté
                'receiver': currentUser,
                'message': message,
                'discussion_id': currentDiscussionId
            })
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadChatHistory();  // Recharge l'historique après l'envoi
            messageInput.value = '';  // Clear input
        })
        .catch(error => console.error('Erreur:', error));
    }
}
    </script>
</body>
<script>
window.embeddedChatbotConfig = {
chatbotId: "F22kLBxNpedwYwO8bAa2U",
domain: "www.chatbase.co"
}
</script>
<script
src="https://www.chatbase.co/embed.min.js"
chatbotId="F22kLBxNpedwYwO8bAa2U"
domain="www.chatbase.co"
defer>
</script>

</html>