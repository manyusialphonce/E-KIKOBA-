<?php
session_start();
include("../config/db.php");

$error = "";

// Check if remember me cookies exist
$email_cookie = $_COOKIE['email'] ?? '';
$pass_cookie  = $_COOKIE['password'] ?? '';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass  = $_POST['password'];
    $remember = isset($_POST['remember']); // checkbox

    $q = $conn->query("SELECT * FROM users WHERE email='$email' LIMIT 1");

    if($q->num_rows > 0){
        $u = $q->fetch_assoc();

        if(password_verify($pass, $u['password'])){
            // Set session
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['role']    = $u['role'];
            

            // Remember me cookies
            if($remember){
                setcookie("email", $email, time() + (86400*30), "/"); // 30 days
                setcookie("password", $pass, time() + (86400*30), "/");
            } else {
                setcookie("email", "", time() - 3600, "/");
                setcookie("password", "", time() - 3600, "/");
            }

            // Redirect based on role
            if($u['role'] == 'super_admin' || $u['role'] == 'admin'){
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../member/dashboard.php");
            }
            exit;
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>E-Kikoba | Login</title>
<link rel="stylesheet" href="../assets/css/login.css">
<style>
/* Optional quick styles for show/hide password */
.show-pass {
    cursor: pointer;
    position: absolute;
    right: 10px;
    top: 10px;
}
.input-group { position: relative; }
</style>
<script>
function togglePassword() {
    var p = document.getElementById("password");
    var icon = document.getElementById("showPass");
    if(p.type === "password"){
        p.type = "text";
        icon.textContent = "🙈";
    } else {
        p.type = "password";
        icon.textContent = "👁️";
    }
}
</script>
</head>
<body class="login-body">

<div class="login-wrapper">

    <div class="login-logo">
        <h1>E - KIKOBA</h1>
    </div>

    <div class="login-card">
        <p class="login-text">Sign in to start your session</p>

        <?php if($error): ?>
            <p style="color:red; font-size:14px;"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email_cookie) ?>" required>
                <span class="icon">✉️</span>
            </div>

            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" value="<?= htmlspecialchars($pass_cookie) ?>" required>
                <span id="showPass" class="show-pass" onclick="togglePassword()">👁️</span>
            </div>

            <div class="login-actions">
                <label><input type="checkbox" name="remember"> Remember Me</label><br><br>
                <button type="submit" name="login">Sign In</button>
            </div>
        </form>

        <div class="register-link">
            <p>Don’t have an account? <a href="register.php">Create account</a></p>
        </div>
    </div>

    <footer class="login-footer">
        © <?= date("Y") ?> E - KIKOBA
    </footer>

</div>
</body>
</html>
