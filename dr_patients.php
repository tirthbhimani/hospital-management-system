<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

$username = $_SESSION['username'];

// GET DOCTOR NAME
$stmt = $con->prepare("SELECT dname FROM doctor_info WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
$doctor = $res->fetch_assoc();
$doctor_name = $doctor['dname'];

// ✅ SAVE PRESCRIPTION
if (isset($_POST['save_prescription'])) {
    $id = $_POST['id'];
    $prescription = $_POST['prescription'];

    $stmt = $con->prepare("UPDATE appointments SET prescription=? WHERE id=?");
    $stmt->bind_param("si", $prescription, $id);
    $stmt->execute();
}

// ✅ UPLOAD REPORT
if (isset($_POST['upload_report'])) {
    $id = $_POST['id'];

    $file = $_FILES['report']['name'];
    $tmp = $_FILES['report']['tmp_name'];

    $path = "uploads/" . time() . "_" . $file;

    move_uploaded_file($tmp, $path);

    $stmt = $con->prepare("UPDATE appointments SET report=? WHERE id=?");
    $stmt->bind_param("si", $path, $id);
    $stmt->execute();
}

// ✅ DELETE ONLY REPORT
if (isset($_GET['delete_report'])) {
    $id = $_GET['delete_report'];

    // get file path
    $res = $con->query("SELECT report FROM appointments WHERE id=$id");
    $row = $res->fetch_assoc();

    if ($row['report'] && file_exists($row['report'])) {
        unlink($row['report']); // delete file
    }

    $con->query("UPDATE appointments SET report=NULL WHERE id=$id");
}

// ✅ COMPLETE TREATMENT (DELETE FULL RECORD)
if (isset($_GET['done'])) {
    $id = $_GET['done'];

    // 1. Get report path
    $stmt = $con->prepare("SELECT report FROM appointments WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    // 2. Delete file if exists
    if ($row && $row['report'] && file_exists($row['report'])) {
        unlink($row['report']);
    }

    // 3. DELETE RECORD FROM DATABASE
    $stmt = $con->prepare("DELETE FROM appointments WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // 4. Refresh page
    header("Location: dr_patients.php");
    exit();
}

// GET DATA
$stmt = $con->prepare("SELECT * FROM appointments WHERE doctor_name=?");
$stmt->bind_param("s", $doctor_name);
$stmt->execute();
$data = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>My Patients</title>
<link rel="stylesheet" href="doctor_style.css">
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>My Patients</h2>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h3>Doctor Panel</h3>
    <ul>
        <li><a href="doctor_home.php">Home</a></li>
        <li><a href="dr_patients.php">My Patients</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<!-- MAIN CONTENT -->
<div class="main-content" id="mainContent">

<h2>Dr. <?php echo $doctor_name; ?></h2>

<table border="1" width="100%">
<tr>
    <th>Patient</th>
    <th>Age</th>
    <th>Date</th>
    <th>Reason</th>
    <th>Status</th>
    <th>Prescription</th>
    <th>Report</th>
    <th>Action</th>
</tr>

<?php
while ($row = $data->fetch_assoc()) {
    echo "<tr>
        <td>{$row['username']}</td>
        <td>{$row['age']}</td>
        <td>{$row['appointment_date']}</td>
        <td>{$row['reason']}</td>
        <td>{$row['status']}</td>

        <td>
            <form method='POST'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <input type='text' name='prescription' value='{$row['prescription']}' placeholder='Write...' required>
                <button name='save_prescription'>Save</button>
            </form>
        </td>

        <td>";
        
        if ($row['report']) {
            echo "
            <a href='{$row['report']}' target='_blank'>View</a><br>
            <a href='?delete_report={$row['id']}'>Delete</a>";
        } else {
            echo "
            <form method='POST' enctype='multipart/form-data'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <input type='file' name='report' required>
                <button name='upload_report'>Upload</button>
            </form>";
        }

        echo "</td>

        <td>
            <a href='?done={$row['id']}' 
               onclick=\"return confirm('Mark as completed? This will delete report & prescription');\">
               Done
            </a>
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