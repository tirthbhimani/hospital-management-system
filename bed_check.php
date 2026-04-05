<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hospital Bed Availability | CityCare Hospital</title>
  <style>
    /* Reset and base styles */
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f2f4f8;
    }

    /* Navbar styling */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #2193b0;
      padding: 12px 18px;
      color: white;
      z-index: 1000;
      flex-wrap: wrap; /* allows wrapping if space is low */
    }

    .navbar .logo {
      font-size: 20px;
      font-weight: bold;
      letter-spacing: 1px;
      flex: 1;
      min-width: 180px;
    }

    .navbar ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      gap: 18px;
      flex-wrap: wrap;
    }

    .navbar ul li {
      position: relative;
    }

    .navbar a {
      text-decoration: none;
      color: white;
      font-weight: 500;
      transition: 0.3s;
      white-space: nowrap;
    }

    .navbar a:hover {
      color: #ffd700;
    }

    /* Dropdown menu */
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
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .navbar ul li ul li:last-child {
      border-bottom: none;
    }

    .navbar ul li:hover ul {
      display: flex;
    }

    /* Mobile menu */
    .menu-toggle {
      display: none;
      font-size: 24px;
      cursor: pointer;
    }

    @media (max-width: 900px) {
      .navbar {
        flex-wrap: nowrap;
      }

      .menu-toggle {
        display: block;
      }

      .navbar ul {
        display: none;
        flex-direction: column;
        width: 100%;
        background-color: #0066cc;
        position: absolute;
        top: 60px;
        left: 0;
        gap: 0;
      }

      .navbar ul.show {
        display: flex;
      }

      .navbar ul li {
        text-align: center;
        padding: 10px 0;
      }
    }

    /* Main content */
    .main-content {
      padding-top: 90px; /* space for fixed navbar */
    }

    header {
      background-color: #2193b0;
      color: white;
      text-align: center;
      padding: 15px 0;
      border-radius: 8px 8px 0 0;
      margin-bottom: 10px;
    }

    .container {
      max-width: 800px;
      margin: 20px auto;
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

    .full {
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
      background-color: #0a6e87;
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

  <!-- Main content -->
  <div class="main-content">
    <div class="container">
      <header>
        <h1>Hospital Bed Availability</h1>
      </header>

      <p><strong>Last Updated:</strong> <span id="lastUpdate">--</span></p>

      <table>
        <thead>
          <tr>
            <th>Ward Name</th>
            <th>Total Beds</th>
            <th>Occupied Beds</th>
            <th>Available Beds</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="bedData"></tbody>
      </table>

      <button id="refresh">Refresh Data</button>
    </div>
  </div>

  <script>
    function toggleMenu() {
      const menu = document.getElementById("menuList");
      menu.classList.toggle("show");
    }

    const wards = [
      { name: "ICU Ward", total: 10, occupied: 7 },
      { name: "General Ward", total: 25, occupied: 20 },
      { name: "Pediatric Ward", total: 8, occupied: 3 },
      { name: "Maternity Ward", total: 12, occupied: 12 },
      { name: "Surgery Ward", total: 15, occupied: 9 }
    ];

    function displayBeds() {
      const tbody = document.getElementById('bedData');
      tbody.innerHTML = '';

      wards.forEach(ward => {
        const available = ward.total - ward.occupied;
        const status = available > 0
          ? `<span class="available">Available</span>`
          : `<span class="full">Full</span>`;

        const row = `
          <tr>
            <td>${ward.name}</td>
            <td>${ward.total}</td>
            <td>${ward.occupied}</td>
            <td>${available}</td>
            <td>${status}</td>
          </tr>`;
        tbody.innerHTML += row;
      });

      document.getElementById('lastUpdate').textContent = new Date().toLocaleString();
    }

    document.getElementById('refresh').addEventListener('click', displayBeds);
    displayBeds();
  </script>
</body>
</html>
