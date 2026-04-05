<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Navbar</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f8fafc;
    }

    /* Navbar Container */
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color:  #2193b0;
      padding: 12px 24px;
      color: white;
    }

    /* Logo */
    .navbar .logo {
      font-size: 22px;
      font-weight: bold;
      letter-spacing: 1px;
    }

    /* Menu Items */
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
  </style>
</head>
<body>

  <nav class="navbar">
    <div class="logo">CityCare Hospital</div>
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

  <script>
    function toggleMenu() {
      const menu = document.getElementById("menuList");
      menu.classList.toggle("show");
    }
  </script>

</body>
</html>
