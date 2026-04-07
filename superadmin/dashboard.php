<?php
include("../config/db.php");
if ($_SESSION['role'] != 'super_admin') {
    header("Location: ../auth/login.php");
}
?>
<h1>Super Admin Dashboard</h1>
<a href="create_kikoba.php">+ Create Kikoba</a><br>
<a href="manage_kikoba.php">View Vikoba</a><br><br>
<a href="../auth/logout.php">Logout</a>
