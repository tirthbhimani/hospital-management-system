<?php
session_start();
/*
// Check login
if (!isset($_SESSION['doctor_name'])) {
    header("Location: index.php");
    exit();
}*/

$doctor_name = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="doctor_style.css">
</head>

<body>

<!-- Topbar -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Doctor Dashboard</h2>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h3>Doctor Panel</h3>
    <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="my_patients.php">My Patients</a></li>
        <li><a href="dr_appointments.php">Appointments</a></li>
        <li><a href="#">Prescriptions</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">

    <!-- Doctor Info -->
    <h1>Welcome Dr. <?php echo $doctor_name; ?></h1>

    <div class="cards">
        <div class="card" id="totalPatients">Total Patients: 0</div>
        <div class="card" id="totalAppointments">Appointments: 0</div>
        <div class="card">Working Time: 10 AM - 5 PM</div>
    </div>

 

</div>

<!-- JS -->
<script>

// Sidebar toggle
document.getElementById("toggleBtn").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("mainContent").classList.toggle("expanded");
});

// ===== LOAD APPOINTMENTS =====
let appointments = JSON.parse(localStorage.getItem("appointments")) || [];

let table = document.getElementById("appointmentTable");

let today = new Date().toISOString().split("T")[0];

let patientSet = new Set();
let countAppointments = 0;

appointments.forEach(a => {

    // Filter today's appointments
    if (a.date === today) {

        countAppointments++;

        patientSet.add(a.patientName);

        table.innerHTML += `
        <tr>
            <td>${a.patientName}</td>
            <td>${a.age}</td>
            <td>${a.gender}</td>
            <td>${a.date}</td>
            <td>${a.time}</td>
            <td>${a.reason}</td>
        </tr>`;
    }
});

// Update cards
document.getElementById("totalAppointments").innerText = "Appointments: " + countAppointments;
document.getElementById("totalPatients").innerText = "Total Patients: " + patientSet.size;

</script>

</body>
</html>