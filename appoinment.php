<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CityCare Hospital - Online Appointment Booking</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f3f6fa;
      margin: 0;
      padding: 0;
    }

    /* Navbar */
    .navbar {
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
      background: #0a6e87e4;
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

    /* Appointment Form */
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

  <!-- Navbar -->
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

  <!-- Appointment Form -->
  <div class="container">
    <h2>Book Your Appointment</h2>

    <form id="appointmentForm">
      <label for="patientName">Patient Name:</label>
      <input type="text" id="patientName" required>

      <label for="age">Age:</label>
      <input type="number" id="age" min="1" required>

      <label for="gender">Gender:</label>
      <select id="gender" required>
        <option value="">-- Select Gender --</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
      </select>

      <label for="doctor">Select Doctor:</label>
      <select id="doctor" required>
        <option value="">-- Choose Doctor --</option>
        <option value="Dr. Meena Sharma - Cardiology">Dr. Meena Sharma - Cardiology</option>
        <option value="Dr. Raj Patel - Orthopedics">Dr. Raj Patel - Orthopedics</option>
        <option value="Dr. Priya Nair - Pediatrics">Dr. Priya Nair - Pediatrics</option>
        <option value="Dr. Sneha Kapoor - Gynecology">Dr. Sneha Kapoor - Gynecology</option>
      </select>

      <label for="date">Appointment Date:</label>
      <input type="date" id="date" required>

      <label for="time">Preferred Time:</label>
      <input type="time" id="time" required>

      <label for="reason">Reason for Visit:</label>
      <textarea id="reason" rows="3" placeholder="Describe symptoms or purpose of visit" required></textarea>

      <button type="submit">Book Appointment</button>
    </form>

    <div id="message"></div>
  </div>

  <script>
    // Toggle navbar menu for mobile
    function toggleMenu() {
      const menu = document.getElementById("menuList");
      menu.classList.toggle("show");
    }

    // Appointment form handling
    const form = document.getElementById("appointmentForm");
    const messageBox = document.getElementById("message");

    form.addEventListener("submit", function(event) {
      event.preventDefault();

      // Collect form data
      const patientName = document.getElementById("patientName").value.trim();
      const age = document.getElementById("age").value.trim();
      const gender = document.getElementById("gender").value;
      const doctor = document.getElementById("doctor").value;
      const date = document.getElementById("date").value;
      const time = document.getElementById("time").value;
      const reason = document.getElementById("reason").value.trim();

      // Validate fields
      if (!patientName || !age || !gender || !doctor || !date || !time || !reason) {
        messageBox.innerHTML = '<div class="error">Please fill out all fields!</div>';
        return;
      }

      // Create appointment object
      const appointment = { patientName, age, gender, doctor, date, time, reason };

      // Save appointment locally (for demo)
      localStorage.setItem("latestAppointment", JSON.stringify(appointment));

      // Show success message
      messageBox.innerHTML = `
        <div class="success">
          Appointment booked successfully!<br><br>
          <strong>${patientName}</strong> with <strong>${doctor}</strong><br>
          on <strong>${date}</strong> at <strong>${time}</strong>.
        </div>
      `;

      // Reset form
      form.reset();
    });
  </script>

</body>
</html>
