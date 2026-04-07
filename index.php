<?php
session_start();
if(isset($_SESSION['role'])){
    if($_SESSION['role']=="admin") header("Location: admin/dashboard.php");
    if($_SESSION['role']=="member") header("Location: member/dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>E-Kikoba | Login</title>

<link rel="stylesheet" href="assets/css/login.css">
<script src="assets/js/app.js" defer></script>
</head>
<body class="login-body">

<div class="login-wrapper">

    <div class="login-logo">
        <h1>E - KIKOBA</h1>
    </div>

    <div class="login-card">
        <p class="login-text">Sign in to start your session</p>

        <form action="auth/login.php" method="POST">

            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
                <span class="icon">✉️</span>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
                <span class="icon">🔒</span>
            </div>

            <div class="login-actions">
                <button type="submit" name="login">Sign In</button>
                <a href="#">Forgot password?</a>
            </div>

        </form>

        <!-- REGISTER LINK -->
        <div class="register-link">
            <p>
                Don’t have an account?
                <a href="auth/register.php">Create account</a>
            </p>
        </div>

    </div>

    <footer class="login-footer">
        © <?= date("Y") ?> E - KIKOBA
    </footer>

</div>

</body>
</html>
