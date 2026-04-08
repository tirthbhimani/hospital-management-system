<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// ADD SCHEDULE
if (isset($_POST['add'])) {

    $doctor = $_POST['doctor'];
    $date = $_POST['date'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    $stmt = $con->prepare("INSERT INTO doctor_schedule (doctor_name, schedule_date, start_time, end_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $doctor, $date, $start, $end);
    $stmt->execute();
}

// DELETE SCHEDULE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $con->query("DELETE FROM doctor_schedule WHERE id = $id");
}

// FETCH DOCTORS
$doctors = $con->query("SELECT dname FROM doctor_info");

// FETCH SCHEDULE
$schedule = $con->query("SELECT * FROM doctor_schedule ORDER BY schedule_date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Schedule</title>
    <link rel="stylesheet" href="doctor_style.css">

    <style>
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        input, select {
            padding: 8px;
            margin: 5px;
        }

        button {
            padding: 8px 12px;
            background: #0a6e87e4;
            color: white;
            border: none;
            cursor: pointer;
        }

        .delete-btn {
            background: red;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
    </style>
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Doctor Schedule (Date Wise)</h2>
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

<div class="container">

<h3>Add Doctor Schedule</h3>

<form method="POST">

<select name="doctor" required>
    <option value="">Select Doctor</option>
    <?php while($row = $doctors->fetch_assoc()) { ?>
        <option value="<?php echo $row['dname']; ?>">
            <?php echo $row['dname']; ?>
        </option>
    <?php } ?>
</select>

<input type="date" name="date" required>
<input type="time" name="start" required>
<input type="time" name="end" required>

<button type="submit" name="add">Add Schedule</button>

</form>

<h3>Schedule List</h3>

<table>
    <tr>
        <th>Doctor</th>
        <th>Date</th>
        <th>Time</th>
        <th>Action</th>
    </tr>

    <?php while($row = $schedule->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['doctor_name']; ?></td>
        <td><?php echo $row['schedule_date']; ?></td>
        <td><?php echo $row['start_time'] . " - " . $row['end_time']; ?></td>
        <td>
            <a href="?delete=<?php echo $row['id']; ?>" 
               onclick="return confirm('Delete this schedule?')">
               <button class="delete-btn">Delete</button>
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

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