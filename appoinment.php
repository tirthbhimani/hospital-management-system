<?php
session_start();

$con = new mysqli("localhost", "root", "", "HMS");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_SESSION['username'];

    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $doctor = $_POST['doctor'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];

    $stmt = $con->prepare("INSERT INTO appointments 
    (username, age, gender, doctor_name, appointment_date, appointment_time, reason) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sisssss", 
        $username,
        $age,
        $gender,
        $doctor,
        $date,
        $time,
        $reason
    );

    if ($stmt->execute()) {
        echo "<script>alert('Appointment Booked Successfully');</script>";
    } else {
        echo "<script>alert('Error');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Book Appointment</title>

  <!-- SAME CSS AS DASHBOARD -->
  <link rel="stylesheet" href="doctor_style.css">

  <!-- KEEP YOUR FORM STYLE EXACT -->
  <style>
    .container {
      max-width: 600px;
      margin: 40px auto;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #2193b0;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 10px;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
      box-sizing: border-box;
      font-size: 15px;
    }

    textarea {
      resize: none;
    }

    button {
      background-color: #2193b0;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
      margin-top: 15px;
      font-size: 16px;
    }

    button:hover {
      background-color: #0a6e87e4;
    }

    .success {
      background-color: #e6ffed;
      color: #006600;
      padding: 10px;
      margin-top: 15px;
      border-radius: 5px;
      text-align: center;
    }

    .error {
      background-color: #ffe6e6;
      color: #cc0000;
      padding: 10px;
      margin-top: 15px;
      border-radius: 5px;
      text-align: center;
    }
  </style>

</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
    <button class="toggle-btn" id="toggleBtn">☰</button>
    <h2 style="margin:0;">Book Appointment</h2>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <h3>Patient Panel</h3>
    <ul>
        <li><a href="patient_home.php">Home</a></li>
        <li><a href="appoinment.php">Book Appointment</a></li>
        <li><a href="my_appointments.php">My Appointments</a></li>
        <li><a href="view_schedule.php">Doctor Schedule</a></li>
        <li><a href="view_beds.php">Bed Availability</a></li>
        <li><a href="index.php">Logout</a></li>
    </ul>
</div>

<!-- MAIN CONTENT -->
<div class="main-content" id="mainContent">

  <div class="container">
    <h2>Book Your Appointment</h2>

    <form method="POST" action="">

  <label>Patient Name:</label>
  <input type="text" value="<?php echo $_SESSION['username']; ?>" readonly>

  <label>Age:</label>
  <input type="number" name="age" value="" required>

  <label>Gender:</label>
  <select name="gender" required>
    <option value="">-- Select Gender --</option>
    <option>Male</option>
    <option>Female</option>
    <option>Other</option>
  </select>

  <label>Doctor:</label>
  <select name="doctor" required>
    <option value="">-- Choose Doctor --</option>
    <option>Dr. Meena Sharma - Cardiology</option>
    <option>Dr. Raj Patel - Orthopedics</option>
    <option>Dr. Priya Nair - Pediatrics</option>
    <option>Dr. Sneha Kapoor - Gynecology</option>
  </select>

  <label>Date:</label>
  <input type="date" name="date" required>

  <label>Time:</label>
  <input type="time" name="time" required>

  <label>Reason:</label>
  <textarea name="reason" rows="3" required></textarea>

  <button type="submit">Book Appointment</button>

</form>

    <div id="message"></div>
  </div>

</div>

<script>

// Sidebar toggle
document.getElementById("toggleBtn").addEventListener("click", function () {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.getElementById("mainContent").classList.toggle("expanded");
});

// Form logic (UNCHANGED)
const form = document.getElementById("appointmentForm");
const messageBox = document.getElementById("message");

form.addEventListener("submit", function(event) {
  event.preventDefault();

  const patientName = document.getElementById("patientName").value.trim();
  const age = document.getElementById("age").value.trim();
  const gender = document.getElementById("gender").value;
  const doctor = document.getElementById("doctor").value;
  const date = document.getElementById("date").value;
  const time = document.getElementById("time").value;
  const reason = document.getElementById("reason").value.trim();

  if (!patientName || !age || !gender || !doctor || !date || !time || !reason) {
    messageBox.innerHTML = '<div class="error">Please fill out all fields!</div>';
    return;
  }

  const appointment = { patientName, age, gender, doctor, date, time, reason };

  let all = JSON.parse(localStorage.getItem("appointments")) || [];
  all.push(appointment);
  localStorage.setItem("appointments", JSON.stringify(all));

  messageBox.innerHTML = `
    <div class="success">
      Appointment booked successfully!<br><br>
      <strong>${patientName}</strong> with <strong>${doctor}</strong><br>
      on <strong>${date}</strong> at <strong>${time}</strong>.
    </div>
  `;

  form.reset();
});

</script>

</body>
</html>