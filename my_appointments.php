<?php 
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$con = new mysqli("localhost", "root", "", "HMS");

$patient_username = $_SESSION['username'];

// Fetch ONLY this patient's appointments
$stmt = $con->prepare("SELECT * FROM appointments WHERE username=?");
$stmt->bind_param("s", $patient_username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <link rel="stylesheet" href="doctor_style.css">
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>My Appointments</h2>
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

<h1><?php echo $patient_username; ?> - Appointments</h1>

<table border="1" width="100%">
<tr>
    <th>Doctor</th>
    <th>Date</th>
    <th>Time</th>
    <th>Reason</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['doctor_name']; ?></td>
    <td><?php echo $row['appointment_date']; ?></td>
    <td><?php echo $row['appointment_time']; ?></td>
    <td><?php echo $row['reason']; ?></td>
</tr>
<?php } ?>

</table>

</div>

<!-- SCRIPT -->
<script>
document.getElementById("toggleBtn").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("mainContent").classList.toggle("expanded");
});
</script>

</body>
</html>