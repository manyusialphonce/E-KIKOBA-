<?php
include("../config/db.php"); // db.php handles session and connection
$user_id = $_SESSION['user_id'];

if(isset($_POST['send'])){
    $amount = $_POST['amount'];

    // Get member info
    $member = $conn->query("SELECT * FROM members WHERE user_id=$user_id")->fetch_assoc();
    if(!$member){
        die("<p style='color:red;'>You are not registered as a member yet.</p>");
    }

    $member_id = $member['id'];
    $kikoba_id = $member['kikoba_id'];

    // Insert loan
    $sql = "INSERT INTO loans (member_id, kikoba_id, amount, status, issued_date)
            VALUES ($member_id, $kikoba_id, $amount, 'pending', CURDATE())";

    if ($conn->query($sql)) {
        echo "<p style='color:green;'>Loan request submitted successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<link rel="stylesheet" href="../assets/css/style.css">

<div class="wrapper">
    <div class="sidebar">
        <a href="dashboard.php">Dashboard</a>
        <a href="my_loans.php">My Loans</a>
    </div>

    <div class="main">
        <h2>Request Loan</h2>
        <form method="post">
            <input type="number" name="amount" placeholder="Amount" required>
            <button type="submit" name="send" class="btn primary">Submit</button>
        </form>
    </div>
</div>
