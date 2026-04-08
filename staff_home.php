<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$staff_name = $_SESSION['username'];

//session_start();
$con = new mysqli("localhost", "root", "", "HMS");

// TOTAL BEDS
$totalBeds = 0;
$res = $con->query("SELECT SUM(total) as total FROM beds");
if ($res && $row = $res->fetch_assoc()) {
    $totalBeds = $row['total'] ?? 0;
}

// AVAILABLE BEDS
$availableBeds = 0;
$res = $con->query("SELECT SUM(total - occupied) as available FROM beds");
if ($res && $row = $res->fetch_assoc()) {
    $availableBeds = $row['available'] ?? 0;
}

// TODAY APPOINTMENTS
$todayAppointments = 0;
$today = date("Y-m-d");

$stmt = $con->prepare("SELECT COUNT(*) as total FROM appointments WHERE appointment_date=?");
if ($stmt) {
    $stmt->bind_param("s", $today);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $todayAppointments = $row['total'] ?? 0;
    }
}

// TOTAL DOCTORS
$totalDoctors = 0;
$res = $con->query("SELECT COUNT(*) as total FROM doctor_info");
if ($res && $row = $res->fetch_assoc()) {
    $totalDoctors = $row['total'] ?? 0;
}

// OCCUPANCY RATE
$occupiedBeds = $totalBeds - $availableBeds;
$rate = ($totalBeds > 0) ? round(($occupiedBeds / $totalBeds) * 100) : 0;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="doctor_style.css">
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Staff Dashboard</h2>
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

<!-- MAIN -->
<div class="main-content" id="mainContent">

    <h1>Welcome Staff: <?php echo $staff_name; ?></h1>

    <div class="cards">
        <div class="card">Total Beds: <?php echo $totalBeds; ?></div>
        <div class="card">Available Beds: <?php echo $availableBeds; ?></div>
        <div class="card">Today's Appointments: <?php echo $todayAppointments; ?></div>
        <div class="card">Total Doctors: <?php echo $totalDoctors; ?></div>
        <div class="card">Occupancy Rate: <?php echo $rate; ?>%</div>
    </div>

</div>

<script>
document.getElementById("toggleBtn").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("mainContent").classList.toggle("expanded");
});
</script>

</body>
</html>