<?php
session_start();

include_once 'C:/xampp/htdocs/Motaz/controller/UtilisateursU.php';

$utilisateurU = new UtilisateursU();

// Check if logged-in user is admin
if (isset($_SESSION['id_user']) && $_SESSION['role'] === 'Admin') {
    $id_user = $_SESSION['id_user'];
    $userDetails = $utilisateurU->recupererUtilisateurs($id_user);
} else {
    header("Location: ../FrontOffice/login.php"); // Redirect to login for non-admins
    exit();
}

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedUser = new Utilisateurs(
        $id_user,
        $_POST['Nom'],
        $_POST['Prenom'],
        $_POST['Age'],
        $_POST['Ville'],
        $_POST['Num_tel'],
        $_POST['Email'],
        $userDetails['Role'], // Keep the same role
        ($_POST['password'] !== '') ? md5($_POST['password']) : $userDetails['password'] // Hash password only if changed
    );

    // Handle profile picture upload
    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['img']['name']);
        $targetFile = $targetDir . $fileName;

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (file_exists($targetFile)) {
                $targetFile = $targetDir . uniqid() . "." . $imageFileType;
            }
            if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFile)) {
                $updatedUser->setImg($targetFile);
            } else {
                echo "Error uploading your file.";
            }
        } else {
            echo "Only JPG, JPEG, PNG, & GIF files are allowed.";
        }
    } else {
        $updatedUser->setImg($userDetails['img']);
    }

    $utilisateurU->modifierUtilisateurs($updatedUser, $id_user);
    $userDetails = $utilisateurU->recupererUtilisateurs($id_user);

    header("Location: profil.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Profile - BackOffice</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/admin-style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <?php include '../BackOffice/navbar.php'; ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Admin Profile</h3>
            </div>
            <div class="card-body">
                <img src="<?php echo $userDetails['img'] ?: 'img/default-avatar.png'; ?>" class="rounded-circle mb-3" style="width: 100px;">
                <h4><?php echo htmlspecialchars($userDetails['Nom'] . ' ' . $userDetails['Prenom']); ?></h4>
                <p>Email: <?php echo htmlspecialchars($userDetails['Email']); ?></p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5>Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Nom">First Name</label>
                        <input type="text" id="Nom" name="Nom" value="<?php echo htmlspecialchars($userDetails['Nom']); ?>" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="Prenom">Last Name</label>
                        <input type="text" id="Prenom" name="Prenom" value="<?php echo htmlspecialchars($userDetails['Prenom']); ?>" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="Email">Email</label>
                        <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($userDetails['Email']); ?>" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Leave blank to keep current" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="img">Profile Picture</label>
                        <input type="file" id="img" name="img" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>
