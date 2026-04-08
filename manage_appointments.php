<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

$result = $con->query("SELECT * FROM appointments");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="doctor_style.css">
</head>

<body>

<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Manage Appointments</h2>
</div>

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

<div class="main-content" id="mainContent">

<h2>All Appointments</h2>

<table border="1" width="100%">
<tr>
    <th>Patient</th>
    <th>Age</th>
    <th>Doctor</th>
    <th>Date</th>
    <th>Time</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['username']; ?></td>
    <td><?php echo $row['age']; ?></td>
    <td><?php echo $row['doctor_name']; ?></td>
    <td><?php echo $row['appointment_date']; ?></td>
    <td><?php echo $row['appointment_time']; ?></td>
</tr>
<?php } ?>

</table>

</div>

<script>
document.getElementById("toggleBtn").onclick = function () {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("mainContent").classList.toggle("expanded");
};
</script>

</body>
</html>