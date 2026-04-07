<?php
include("../config/db.php");
if ($_SESSION['role'] != 'super_admin') {
    header("Location: ../auth/login.php");
}

$vikoba = $conn->query(
 "SELECT v.*, u.full_name AS admin
  FROM vikoba v
  LEFT JOIN users u ON v.admin_id = u.id"
);
?>

<h2>All Vikoba</h2>

<table border="1" cellpadding="10">
<tr>
  <th>Name</th>
  <th>Location</th>
  <th>Contribution</th>
  <th>Admin</th>
</tr>

<?php while($v = $vikoba->fetch_assoc()) { ?>
<tr>
  <td><?= $v['name'] ?></td>
  <td><?= $v['location'] ?></td>
  <td><?= $v['contribution_amount'] ?></td>
  <td><?= $v['admin'] ?></td>
</tr>
<?php } ?>
</table>