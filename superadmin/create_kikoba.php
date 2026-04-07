<?php
include("../config/db.php");
if ($_SESSION['role'] != 'super_admin') {
    header("Location: ../auth/login.php");
}

// get admins (users without kikoba)
$admins = $conn->query("SELECT * FROM users WHERE role='admin' AND kikoba_id IS NULL");

if (isset($_POST['create'])) {
    $name   = $_POST['name'];
    $loc    = $_POST['location'];
    $amount = $_POST['amount'];
    $admin  = $_POST['admin_id'];

    $stmt = $conn->prepare(
      "INSERT INTO vikoba (name, location, contribution_amount, admin_id)
       VALUES (?,?,?,?)"
    );
    $stmt->bind_param("ssdi", $name, $loc, $amount, $admin);
    $stmt->execute();

    $kikoba_id = $conn->insert_id;

    // update admin
    $conn->query("UPDATE users SET kikoba_id=$kikoba_id WHERE id=$admin");

    echo "Kikoba created successfully!";
}
?>

<h2>Create Kikoba</h2>

<form method="POST">
    <input name="name" placeholder="Kikoba Name" required><br><br>
    <input name="location" placeholder="Location"><br><br>
    <input type="number" name="amount" placeholder="Monthly Contribution" required><br><br>

    <select name="admin_id" required>
        <option value="">Select Admin</option>
        <?php while($a = $admins->fetch_assoc()) { ?>
            <option value="<?= $a['id'] ?>"><?= $a['full_name'] ?></option>
        <?php } ?>
    </select><br><br>

    <button name="create">Create Kikoba</button>
</form>