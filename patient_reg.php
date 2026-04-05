<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['fname']);
    $last_name = trim($_POST['lname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Database connection
    $con = new mysqli("localhost", "root", "", "HMS");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Check if username already exists
    $check = $con->prepare("SELECT * FROM patient_registration WHERE username=?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists! Please choose another.');</script>";
    } else {
        $stmt = $con->prepare("INSERT INTO patient_registration (fname, lname, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $last_name, $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Redirecting to login...'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Error during registration: " . $stmt->error . "');</script>";
        }
    }

    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Patient Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Navbar Styles */
    .navbar {
      position: fixed;              /* ✅ Fix navbar at top */
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;               /* Keeps navbar above all content */
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #2193b0;
      padding: 12px 24px;
      color: white;
    }

    .navbar .logo {
      font-size: 22px;
      font-weight: bold;
      letter-spacing: 1px;
    }

    .navbar ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      gap: 25px;
    }

    .navbar ul li {
      position: relative;
    }

    .navbar a {
      text-decoration: none;
      color: white;
      font-weight: 500;
      transition: 0.3s;
    }

    .navbar a:hover {
      color: #ffd700;
    }

    .navbar ul li ul {
      position: absolute;
      top: 40px;
      left: 0;
      background: #004999;
      display: none;
      flex-direction: column;
      border-radius: 5px;
      min-width: 160px;
      z-index: 1000;
    }

    .navbar ul li ul li {
      padding: 10px;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .navbar ul li ul li:last-child {
      border-bottom: none;
    }

    .navbar ul li:hover ul {
      display: flex;
    }

    .menu-toggle {
      display: none;
      font-size: 24px;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .navbar ul {
        display: none;
        flex-direction: column;
        width: 100%;
        background-color: #0066cc;
        position: absolute;
        top: 60px;
        left: 0;
      }

      .navbar ul.show {
        display: flex;
      }

      .navbar ul li {
        text-align: center;
        padding: 10px 0;
      }

      .menu-toggle {
        display: block;
      }
    }

    /* Page Background & Registration Card */
    body {
      /* background: linear-gradient(90deg, #34b4e3, #5fe3f0); */
      background-color: #fff;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding-top: 80px; /* ✅ Space for fixed navbar */
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .registration-card {
      background-color: white;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      padding: 40px;
      width: 100%;
      max-width: 450px;
      margin: 30px auto;
    }

    .registration-card h3 {
      text-align: center;
      margin-bottom: 25px;
      color: #2193b0;
      font-weight: 600;
    }

    .form-control {
      border-radius: 10px;
      padding: 10px;
    }

    .btn {
      background: #2193b0;
      color: #fff;
      border-radius: 10px;
      width: 100%;
      font-weight: 600;
      padding: 10px;
      transition: 0.3s;
    }

    .btn:hover {
      background:  #0a6e87e4;
      transform: scale(1.03);
    }

    .text-center a {
      text-decoration: none;
      color: #007bff;
      font-weight: 500;
    }

    .text-center a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <!-- ✅ Fixed Navbar -->
  <nav class="navbar">
    <div class="logo">🏥 CityCare Hospital</div>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
    <ul id="menuList">
      <li><a href="#">Home</a></li>
      <li><a href="#">About Us</a></li>
      <li>
        <a href="#">Departments ▼</a>
        <ul>
          <li><a href="#">Cardiology</a></li>
          <li><a href="#">Orthopedics</a></li>
          <li><a href="#">Neurology</a></li>
          <li><a href="#">Pediatrics</a></li>
        </ul>
      </li>
      <li><a href="#">Doctors</a></li>
      <li><a href="#">Appointments</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </nav>

  <div class="registration-card">
    <h3>🩺 Patient Registration</h3>
    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">First Name</label>
        <input type="text" class="form-control" name="fname" placeholder="Enter first name" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Last Name</label>
        <input type="text" class="form-control" name="lname" placeholder="Enter last name" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" placeholder="Create a username" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Create a password" required>
      </div>

      <button type="submit" class="btn mt-2">Register</button>

      <div class="text-center mt-3">
        <p>Already have an account? <a href="index.php">Login here</a></p>
      </div>
    </form>
  </div>

  <script>
    function toggleMenu() {
      const menu = document.getElementById("menuList");
      menu.classList.toggle("show");
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
