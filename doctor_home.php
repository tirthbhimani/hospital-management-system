<?php
session_start();
$con = new mysqli("localhost", "root", "", "HMS");

// GET USERNAME
$username = $_SESSION['username'];

// GET DOCTOR FULL NAME FROM doctor_info
$doctor_name = "";
$stmt = $con->prepare("SELECT dname FROM doctor_info WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $doctor_name = $row['dname'];
}

// TODAY DATE
$today = date("Y-m-d");

// TODAY APPOINTMENTS
$todayAppointments = 0;
$stmt = $con->prepare("SELECT COUNT(*) as total FROM appointments WHERE doctor_name=? AND appointment_date=?");
$stmt->bind_param("ss", $doctor_name, $today);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $todayAppointments = $row['total'];
}

// TOTAL PATIENTS (UNIQUE)
$totalPatients = 0;
$stmt = $con->prepare("SELECT COUNT(DISTINCT username) as total FROM appointments WHERE doctor_name=?");
$stmt->bind_param("s", $doctor_name);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $totalPatients = $row['total'];
}

// PENDING APPOINTMENTS
$pendingAppointments = 0;
$stmt = $con->prepare("SELECT COUNT(*) as total FROM appointments WHERE doctor_name=? AND appointment_date>=?");
$stmt->bind_param("ss", $doctor_name, $today);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $pendingAppointments = $row['total'];
}
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
        <li><a href="doctor_home.php">Home</a></li>
        <li><a href="dr_patients.php">My Patients</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">

    <!-- Doctor Info -->
    <h1>Welcome <?php echo $doctor_name; ?></h1>

   <div class="cards">

    <div class="card">
        Today Appointments: <?php echo $todayAppointments; ?>
    </div>

    <div class="card">
        Total Patients: <?php echo $totalPatients; ?>
    </div>

    <div class="card">
        Pending Appointments: <?php echo $pendingAppointments; ?>
    </div>

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