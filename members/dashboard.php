<?php
session_start();
include("../config/db.php");

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>E-Kikoba</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="my_contributions.php">My Contributions</a>
        <a href="my_loans.php">My Loans</a>
        <a href="request_loan.php">Request Loan</a>
        <a href="../auth/logout.php">Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="topbar">
            <h2>Welcome Member</h2>
        </div>

        <div class="cards">

            <div class="card">
                <h4>Total Contributions</h4>
                <p>
<?=
number_format(
    $conn->query("SELECT SUM(amount) t FROM contributions WHERE member_id=$user_id")
         ->fetch_assoc()['t']
);
?>
</p>

            </div>

            <div class="card">
                <h4>Total Loans</h4>
                <p>
                <?=
                number_format(
                    $conn->query("SELECT SUM(amount) t FROM loans WHERE member_id=$user_id")
                         ->fetch_assoc()['t']
                );
                ?>
                </p>
            </div>

            <div class="card">
                <h4>Pending Loans</h4>
                <p>
                <?=
                $conn->query("SELECT COUNT(*) t FROM loans 
                              WHERE member_id=$user_id AND status='pending'")
                     ->fetch_assoc()['t'];
                ?>
                </p>
            </div>

        </div>

    </div>
</div>

<script src="../assets/js/app.js"></script>
</body>
</html>