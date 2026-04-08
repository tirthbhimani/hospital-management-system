<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$result = $con->query("SELECT * FROM beds");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bed Availability</title>
    <link rel="stylesheet" href="doctor_style.css">
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Bed Availability</h2>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h3>Patient Panel</h3>
    <ul>
        <li><a href="patient_home.php">Home</a></li>
        <li><a href="appoinment.php">Book Appointment</a></li>
        <li><a href="my_appointments.php">My Appointments</a></li>
        <li><a href="view_schedule.php">Doctor Schedule</a></li>
        <li><a href="view_beds.php">Bed Availability</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<!-- MAIN -->
<div class="main-content" id="mainContent">

<h2>Bed Availability</h2>

<table border="1" width="100%">
<tr>
    <th>Ward</th>
    <th>Total</th>
    <th>Occupied</th>
    <th>Available</th>
    <th>Status</th>
</tr>

<?php while($row = $result->fetch_assoc()) { 
    $available = $row['total'] - $row['occupied'];
?>
<tr>
    <td><?php echo $row['ward_name']; ?></td>
    <td><?php echo $row['total']; ?></td>
    <td><?php echo $row['occupied']; ?></td>
    <td><?php echo $available; ?></td>
    <td style="color: <?php echo ($available > 0 ? 'green' : 'red'); ?>">
        <?php echo ($available > 0 ? 'Available' : 'Full'); ?>
    </td>
</tr>
<?php } ?>

</table>

</div>

<script>
document.getElementById("toggleBtn").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("mainContent").classList.toggle("expanded");
});
</script>

</body>
</html>