<?php

require_once '../../config.php'; 


$con = config::getConnexion();


if (isset($_GET['token'])) {
    $token = $_GET['token'];

    
    $stmt = $con->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $new_password = md5($_POST['password']);  

           
            $stmt = $con->prepare("UPDATE users SET Password = ?, reset_token = NULL, reset_expiry = NULL WHERE reset_token = ?");
            $stmt->execute([$new_password, $token]);

            echo "Password has been reset successfully.";
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No token provided.";
}
?>

<!-- Password reset form -->
<style>
/* Styling (same as before, adjust as necessary) */
.container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.form-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.5em;
    color: #333;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="password"], input[type="email"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn-submit {
    display: block;
    width: 100%;
    padding: 10px;
    border: none;
    background-color: #007bff;
    color: white;
    font-size: 1em;
    border-radius: 5px;
    cursor: pointer;
    text-transform: uppercase;
}

.btn-submit:hover {
    background-color: #0056b3;
}
</style>


<div class="container">
    <h2 class="form-title">Reset Password</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn-submit">Reset Password</button>
    </form>
</div>
