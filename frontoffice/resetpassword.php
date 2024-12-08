<?php
require_once '../../config.php'; 

// Establish database connection
$con = config::getConnexion();

// Initialize error and success messages
$error = '';
$success = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate token and check expiry
    $stmt = $con->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validate passwords
            if ($new_password === $confirm_password) {
                $hashed_password = md5($new_password);

                // Update password in the database
                $stmt = $con->prepare("UPDATE users SET Password = ?, reset_token = NULL, reset_expiry = NULL WHERE reset_token = ?");
                $stmt->execute([$hashed_password, $token]);

                $success = "Password has been reset successfully. Redirecting to login...";
                header("refresh:3;url=login.php"); 
                exit;
            } else {
                $error = "Passwords do not match. Please try again.";
            }
        }
    } else {
        $error = "Invalid or expired token.";
    }
} else {
    $error = "No token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    


    
    <style>
        body {
            background: linear-gradient(to bottom, #f0f9ff, #ffffff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .reset-card {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .reset-card h2 {
            color: #0c4a6e;
            text-align: center;
            margin-bottom: 1rem;
        }
        .btn-primary {
            background: #0cc0df;
            border: none;
        }
        .btn-primary:hover {
            background: #0369a1;
        }
        .error-msg {
            color: red;
            margin-bottom: 1rem;
            text-align: center;
        }
        .success-msg {
            color: green;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>

    
</head>
<body>
    <div class="reset-card">
        <h2>Reset Your Password</h2>
        <?php if ($error): ?>
            <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success-msg"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if (isset($user) && $user): ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" id="new_password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>

    <script src="reset.js"></script>



</body>
</html>






