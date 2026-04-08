<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

$username = $_SESSION['username']; // login username

// 🔥 GET FULL DOCTOR NAME FROM doctor_info TABLE
$stmt = $con->prepare("SELECT dname FROM doctor_info WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

$doctor = $res->fetch_assoc();
$doctor_name = $doctor['dname'] ?? "";

// DEBUG
echo "<h3>Doctor: $doctor_name</h3>";

// NOW FETCH APPOINTMENTS
$stmt2 = $con->prepare("SELECT * FROM appointments WHERE doctor_name=?");
$stmt2->bind_param("s", $doctor_name);
$stmt2->execute();
$data = $stmt2->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Appointments</title>
    <link rel="stylesheet" href="doctor_style.css">
</head>

<body>

<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>My Appointments</h2>
    
</div>

<div class="sidebar" id="sidebar">
    <h3>Doctor Panel</h3>
    <ul>
        <li><a href="doctor_home.php">Home</a></li>
        <li><a href="my_patients.php">My Patients</a></li>
        <li><a href="dr_appointments.php">Appointments</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<div class="main-content" id="mainContent">

<h1>Dr. <?php echo $doctor_name; ?> - Appointments</h1>

<table border="1" width="100%">
<tr>
    <th>Patient</th>
    <th>Age</th>
    <th>Date</th>
    <th>Time</th>
    <th>Reason</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$result = $con->prepare("SELECT * FROM appointments WHERE doctor_name=?");
$result->bind_param("s", $doctor_name);
$result->execute();
$data = $result->get_result();
//echo $username;

while ($row = $data->fetch_assoc()) {
    echo "<tr>
        <td>{$row['username']}</td>
        <td>{$row['age']}</td>
        <td>{$row['appointment_date']}</td>
        <td>{$row['appointment_time']}</td>
        <td>{$row['reason']}</td>
        <td>{$row['status']}</td>
        <td>
            <a href='?done={$row['id']}'>Done</a>

            <form method='POST' style='display:inline;'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <input type='text' name='prescription' placeholder='Add Prescription' required>
                <button type='submit'>Save</button>
            </form>
        </td>
    </tr>";
}
?>

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