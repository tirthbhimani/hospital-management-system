<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

// TOTAL DOCTORS
$totalDoctors = 0;
$res = $con->query("SELECT COUNT(*) as total FROM doctor_info");
if ($res && $row = $res->fetch_assoc()) {
    $totalDoctors = $row['total'];
}

// TOTAL STAFF
$totalStaff = 0;
$res = $con->query("SELECT COUNT(*) as total FROM staff_info");
if ($res && $row = $res->fetch_assoc()) {
    $totalStaff = $row['total'];
}

// TOTAL PATIENTS
$totalPatients = 0;
$res = $con->query("SELECT COUNT(*) as total FROM patient_registration");
if ($res && $row = $res->fetch_assoc()) {
    $totalPatients = $row['total'];
}

// TOTAL APPOINTMENTS
$totalAppointments = 0;
$res = $con->query("SELECT COUNT(*) as total FROM appointments");
if ($res && $row = $res->fetch_assoc()) {
    $totalAppointments = $row['total'];
}

// TOTAL BEDS
$totalBeds = 0;
$res = $con->query("SELECT SUM(total) as total FROM beds");
if ($res && $row = $res->fetch_assoc()) {
    $totalBeds = $row['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="doctor_style.css">
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Admin Dashboard</h2>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h3>Admin Panel</h3>
    <ul>
        <li><a href="admin_home.php">Home</a></li>
        <li><a href="add_doctor.php">Add Doctor</a></li>
        <li><a href="add_staff.php">Add Staff</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<!-- MAIN -->
<div class="main-content" id="mainContent">

<h1>Welcome Admin</h1>

<div class="cards">
    <div class="card">Total Doctors: <?php echo $totalDoctors; ?></div>
    <div class="card">Total Staff: <?php echo $totalStaff; ?></div>
    <div class="card">Total Patients: <?php echo $totalPatients; ?></div>
    <div class="card">Total Appointments: <?php echo $totalAppointments; ?></div>
    <div class="card">Total Beds: <?php echo $totalBeds; ?></div>
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