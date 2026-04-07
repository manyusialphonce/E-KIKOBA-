<?php
session_start();
include("../config/db.php");
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Loans</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="wrapper">

    <div class="sidebar">
        <h2>E-Kikoba</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="my_contributions.php">My Contributions</a>
        <a href="my_loans.php">My Loans</a>
        <a href="request_loan.php">Request Loan</a>
        <a href="../auth/logout.php">Logout</a>
    </div>

    <div class="main">

        <div class="topbar">
            <h2>My Loans</h2>
        </div>

        <table>
            <tr>
                <th>#</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>

            <?php
            $i = 1;
            $q = $conn->query("SELECT * FROM loans 
                               WHERE member_id=$user_id 
                               ORDER BY id DESC");

            while($r = $q->fetch_assoc()):
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= number_format($r['amount']) ?></td>
                <td>
                    <span class="badge <?= $r['status'] ?>">
                        <?= ucfirst($r['status']) ?>
                    </span>
                </td>
                <td><?= $r['date'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

    </div>
</div>

<script src="../assets/js/app.js"></script>
</body>
</html>