<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

/* =========================
   DISCHARGE (reduce occupied)
========================= */
if (isset($_GET['discharge'])) {
    $id = $_GET['discharge'];

    $con->query("UPDATE beds 
                 SET occupied = GREATEST(occupied - 1, 0) 
                 WHERE id = $id");
}

/* =========================
   DELETE WARD
========================= */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $con->query("DELETE FROM beds WHERE id = $id");
}

/* =========================
   ADD NEW BED DATA
========================= */
if (isset($_POST['add'])) {
    $ward = $_POST['ward_name'];
    $total = $_POST['total'];
    $occupied = $_POST['occupied'];

    if ($occupied > $total) {
        echo "<script>alert('Occupied cannot be greater than total beds');</script>";
    } else {
        $stmt = $con->prepare("INSERT INTO beds (ward_name, total, occupied) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $ward, $total, $occupied);
        $stmt->execute();
    }
}

/* =========================
   FETCH DATA
========================= */
$result = $con->query("SELECT * FROM beds");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Beds</title>
    <link rel="stylesheet" href="doctor_style.css">

    <style>
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        input {
            padding: 8px;
            margin: 5px;
            width: 30%;
        }

        button {
            padding: 10px;
            background: #2193b0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        .available { color: green; font-weight: bold; }
        .full { color: red; font-weight: bold; }

        a {
            text-decoration: none;
            color: #2193b0;
            font-weight: bold;
        }
    </style>
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Manage Bed Availability</h2>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h3>Staff Panel</h3>
    <ul>
        <li><a href="staff_home.php">Home</a></li>
        <li><a href="manage_appointments.php">Manage Appointments</a></li>
        <li><a href="manage_beds.php">Manage Beds</a></li>
        <li><a href="doctor_schedule.php">Doctor Schedule</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<!-- MAIN CONTENT -->
<div class="main-content" id="mainContent">

<div class="container">

<h3>Add Ward / Bed Info</h3>

<form method="POST">
    <input type="text" name="ward_name" placeholder="Ward Name" required>
    <input type="number" name="total" placeholder="Total Beds" required>
    <input type="number" name="occupied" placeholder="Occupied Beds" required>
    <button name="add">Add</button>
</form>

<hr>

<h3>All Bed Availability</h3>

<table border="1" width="100%">
<tr>
    <th>Ward</th>
    <th>Total</th>
    <th>Occupied</th>
    <th>Available</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { 
    $available = $row['total'] - $row['occupied'];
    $status = $available > 0 
        ? "<span class='available'>Available</span>" 
        : "<span class='full'>Full</span>";
?>

<tr>
    <td><?php echo $row['ward_name']; ?></td>
    <td><?php echo $row['total']; ?></td>
    <td><?php echo $row['occupied']; ?></td>
    <td><?php echo $available; ?></td>
    <td><?php echo $status; ?></td>
    <td>
        <a href="?discharge=<?php echo $row['id']; ?>">Discharge</a> |
        <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this ward?')">Delete</a>
    </td>
</tr>

<?php } ?>

</table>

</div>
</div>

<script>
// Sidebar toggle
document.getElementById("toggleBtn").onclick = function () {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("mainContent").classList.toggle("expanded");
};
</script>

</body>
</html>