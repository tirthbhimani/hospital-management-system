<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

// TOTAL APPOINTMENTS
$stmt = $con->prepare("SELECT COUNT(*) as total FROM appointments WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$total = $res['total'];

// NEXT APPOINTMENT
$stmt = $con->prepare("SELECT appointment_date, appointment_time 
                       FROM appointments 
                       WHERE username=? 
                       ORDER BY appointment_date ASC 
                       LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$next = $stmt->get_result()->fetch_assoc();

$next_text = $next 
    ? $next['appointment_date'] . " (" . $next['appointment_time'] . ")" 
    : "None";

// HEALTH STATUS
$status = ($total > 0) ? "Under Treatment" : "Active";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="patient.css">
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Patient Dashboard</h2>
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

    <h1>Welcome <?php echo $username; ?></h1>

    <div class="cards">
        <div class="card">Total Appointments: <?php echo $total; ?></div>
        <div class="card">Next Appointment: <?php echo $next_text; ?></div>
        <div class="card">Health Status: <?php echo $status; ?></div>
    </div>

</div>

<script>
// ✅ ONLY TOGGLE CODE (clean, no errors)
document.getElementById("toggleBtn").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("mainContent").classList.toggle("expanded");
});
</script>

</body>
</html>