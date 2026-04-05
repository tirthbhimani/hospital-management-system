<?php
session_start();

/*if (!isset($_SESSION['doctor_name'])) {
    header("Location: index.php");
    exit();
}*/

$doctor_name = $_SESSION['doctor_name'] ?? "Doctor";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointments</title>
    <link rel="stylesheet" href="doctor_style.css">
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Appointments</h2>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h3>Doctor Panel</h3>
    <ul>
        <li><a href="doctor_home.php">Dashboard</a></li>
        <li><a href="my_patients.php">My Patients</a></li>
        <li><a href="appointments.php">Appointments</a></li>
        <li><a href="#">Prescriptions</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<!-- MAIN -->
<div class="main-content" id="mainContent">

    <h1>Dr. <?php echo $doctor_name; ?> - Appointments</h1>

    <table border="1" width="100%" style="margin-top:20px;">
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Date</th>
            <th>Time</th>
            <th>Reason</th>
        </tr>
        <tbody id="appointmentTable"></tbody>
    </table>

</div>

<script>
// Sidebar toggle
document.getElementById("toggleBtn").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("mainContent").classList.toggle("expanded");
});

// Load data
let data = JSON.parse(localStorage.getItem("appointments")) || [];
let table = document.getElementById("appointmentTable");

data.forEach(a => {
    table.innerHTML += `
    <tr>
        <td>${a.patientName}</td>
        <td>${a.age}</td>
        <td>${a.gender}</td>
        <td>${a.date}</td>
        <td>${a.time}</td>
        <td>${a.reason}</td>
    </tr>`;
});
</script>

</body>
</html>