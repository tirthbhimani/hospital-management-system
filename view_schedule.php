<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$result = $con->query("SELECT * FROM doctor_schedule ORDER BY schedule_date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Schedule</title>
    <link rel="stylesheet" href="doctor_style.css">
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Doctor Schedule</h2>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h3>Patient Panel</h3>
    <ul>
        <li><a href="patient_home.php">Home</a></li>
        <li><a href="apoiment.php">Book Appointment</a></li>
        <li><a href="my_appointments.php">My Appointments</a></li>
        <li><a href="view_schedule.php">Doctor Schedule</a></li>
        <li><a href="view_beds.php">Bed Availability</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<!-- MAIN -->
<div class="main-content" id="mainContent">

<h2>Doctor Schedule</h2>

<table border="1" width="100%">
<tr>
    <th>Doctor</th>
    <th>Date</th>
    <th>Time</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['doctor_name']; ?></td>
    <td><?php echo $row['schedule_date']; ?></td>
    <td><?php echo $row['start_time'] . " - " . $row['end_time']; ?></td>
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