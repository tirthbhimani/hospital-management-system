<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// INSERT STAFF
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $sname = trim($_POST['Sname']); // MUST match column name

    // 🔥 CHECK DUPLICATE USERNAME
    $check = $con->prepare("SELECT * FROM staff_info WHERE username=?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {

        $stmt = $con->prepare("INSERT INTO staff_info (username, password, Sname) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $sname);

        if ($stmt->execute()) {
            echo "<script>alert('Staff Added Successfully');</script>";
        } else {
            echo "<script>alert('Error adding staff');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Staff</title>
    <link rel="stylesheet" href="doctor_style.css">

    <style>
        .form-box {
            max-width: 500px;
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .form-box input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .form-box button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #2193b0;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .form-box button:hover {
            background: #0a6e87e4;
        }
    </style>
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2>Add Staff</h2>
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

    <div class="form-box">
        <h2 style="text-align:center;">Add New Staff</h2>

        <form method="POST">

            <label>Staff Full Name</label>
            <input type="text" name="Sname" placeholder="Enter full name" required>

            <label>Username</label>
            <input type="text" name="username" placeholder="Enter username" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>

            <button type="submit">Add Staff</button>

        </form>
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