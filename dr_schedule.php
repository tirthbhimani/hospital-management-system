<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CityCare Hospital - Doctor Availability</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f6fa;
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

    /* Dropdown Menu */
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

    /* Mobile Menu Toggle */
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

    /* Header Section */
    header {
      background-color: #2193b0;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: 60px;
    }

    /* Doctor Schedule Container */
    .container {
      max-width: 900px;
      margin: 20px auto;
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: #2193b0;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .available {
      color: green;
      font-weight: bold;
    }

    .unavailable {
      color: red;
      font-weight: bold;
    }

    #refresh {
      background-color: #2193b0;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
    }

    #refresh:hover {
      background-color: #0a6e87e4;
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

  <!-- Page Header -->
  <header>
    <h1>Doctor Availability & Schedule</h1>
  </header>

  <!-- Doctor Table -->
  <div class="container">
    <p><strong>Last Updated:</strong> <span id="lastUpdate">--</span></p>

    <table>
      <thead>
        <tr>
          <th>Doctor Name</th>
          <th>Department</th>
          <th>Available Today</th>
          <th>Timing</th>
          <th>Next Available Day</th>
        </tr>
      </thead>
      <tbody id="doctorData">
        <!-- Dynamic doctor schedule will appear here -->
      </tbody>
    </table>

    <button id="refresh">Refresh Data</button>
  </div>

  <script>
    // Navbar Toggle
    function toggleMenu() {
      const menu = document.getElementById("menuList");
      menu.classList.toggle("show");
    }

    // Doctor Data
    const doctors = [
      { name: "Dr. Meena Sharma", department: "Cardiology", available: true, timing: "10:00 AM - 2:00 PM", nextDay: "Tomorrow" },
      { name: "Dr. Raj Patel", department: "Orthopedics", available: false, timing: "—", nextDay: "Wednesday" },
      { name: "Dr. Priya Nair", department: "Pediatrics", available: true, timing: "9:00 AM - 1:00 PM", nextDay: "Tomorrow" },
      { name: "Dr. Arjun Desai", department: "Neurology", available: false, timing: "—", nextDay: "Thursday" },
      { name: "Dr. Sneha Kapoor", department: "Gynecology", available: true, timing: "11:00 AM - 3:00 PM", nextDay: "Tomorrow" }
    ];

    function displayDoctors() {
      const tbody = document.getElementById('doctorData');
      tbody.innerHTML = '';

      doctors.forEach(doc => {
        const status = doc.available ? 
          `<span class="available">Available</span>` : 
          `<span class="unavailable">Not Available</span>`;

        const row = `
          <tr>
            <td>${doc.name}</td>
            <td>${doc.department}</td>
            <td>${status}</td>
            <td>${doc.timing}</td>
            <td>${doc.nextDay}</td>
          </tr>
        `;
        tbody.innerHTML += row;
      });

      document.getElementById('lastUpdate').textContent = new Date().toLocaleString();
    }

    // Event Listener
    document.getElementById('refresh').addEventListener('click', displayDoctors);

    // Initial Load
    displayDoctors();
  </script>

</body>
</html>
