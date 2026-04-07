<?php
include("../config/db.php");

$message = ""; // feedback message

if(isset($_POST['reg'])){
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->query("SELECT id FROM users WHERE email='$email'");
    if($check->num_rows > 0){
        $message = "<p class='error-msg'>Email already registered! Try another.</p>";
    } else {
        $conn->query("INSERT INTO users(full_name,email,password,role)
                      VALUES('$name','$email','$pass','member')");
        $message = "<p class='success-msg'>Account created successfully! <a href='../index.php'>Sign in</a></p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>E-Kikoba | Create Account</title>

<!-- SAME STYLE AS LOGIN -->
<link rel="stylesheet" href="../assets/css/login.css">
<script src="../assets/js/app.js" defer></script>
</head>

<body class="login-body">

<div class="login-wrapper">

    <!-- LOGO -->
    <div class="login-logo">
        <h1>E - KIKOBA</h1>
    </div>

    <!-- REGISTER CARD -->
    <div class="login-card">
        <p class="login-text">Create your account</p>

        <?php if($message) echo $message; ?>

        <form method="POST">

            <div class="input-group">
                <input type="text" name="name" placeholder="Full Name" required>
            </div>

            <div class="input-group">
                <input type="email" name="email" placeholder="Email Address" required>
                <span class="icon">✉️</span>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
                <span class="icon">🔒</span>
            </div>

            <button class="btn-full" type="submit" name="reg">
                Create Account
            </button>
        </form>

        <!-- BACK TO LOGIN -->
        <div class="register-link">
            <p>
                Already have an account?
                <a href="../index.php">Sign In</a>
            </p>
        </div>

    </div>

    <footer class="login-footer">
        © <?= date("Y") ?> E - KIKOBA
    </footer>

</div>

</body>
</html>
