<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['fname']);
    $last_name = trim($_POST['lname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $con = new mysqli("localhost", "root", "", "HMS");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $check = $con->prepare("SELECT * FROM patient_registration WHERE username=?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        $stmt = $con->prepare("INSERT INTO patient_registration (fname, lname, username, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $last_name, $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Error');</script>";
        }
    }

    $con->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Patient Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f3f6fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: Arial;
    }

    .registration-card {
      background: white;
      padding: 35px;
      border-radius: 12px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h3 {
      text-align: center;
      color: #2193b0;
      margin-bottom: 20px;
    }

    .form-control {
      margin-bottom: 12px;
    }

    .btn {
      width: 100%;
      background: #2193b0;
      color: white;
    }

    .btn:hover {
      background: #0a6e87;
    }

    .text-center a {
      text-decoration: none;
    }
  </style>
</head>

<body>

<div class="registration-card">
  <h3>Patient Registration</h3>

  <form method="POST">
    <input type="text" name="fname" class="form-control" placeholder="First Name" required>
    <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
    <input type="text" name="username" class="form-control" placeholder="Username" required>
    <input type="password" name="password" class="form-control" placeholder="Password" required>

    <button type="submit" class="btn mt-2">Register</button>

    <div class="text-center mt-3">
      <a href="index.php">← Back to Login</a>
    </div>
  </form>
</div>

</body>
</html>