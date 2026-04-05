<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CityCare Hospital - Weekly Schedule</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      font-family: Arial;
      margin: 0;
      background: #f3f6fa;
    }

    .navbar {
      background: #2193b0;
      color: white;
      padding: 15px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
    }

    header {
      text-align: center;
      padding: 15px;
      color: white;
      background: #2193b0;
    }

    .container {
      max-width: 1000px;
      margin: 20px auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 900px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background: #2193b0;
      color: white;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
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
      margin-top: 10px;
      padding: 10px 20px;
      background: #2193b0;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    #refresh:hover {
      background: #0a6e87;
    }
  </style>
</head>

<body>

  <div class="navbar">🏥 CityCare Hospital</div>

  <header>
    <h2>Doctor Weekly Schedule</h2>
  </header>

  <div class="container">

    <p><strong>Last Updated:</strong> <span id="lastUpdate">--</span></p>

    <table>
      <thead>
        <tr>
          <th>Doctor</th>
          <th>Department</th>
          <th>Mon</th>
          <th>Tue</th>
          <th>Wed</th>
          <th>Thu</th>
          <th>Fri</th>
          <th>Sat</th>
          <th>Sun</th>
        </tr>
      </thead>

      <tbody id="doctorData"></tbody>
    </table>

    <button id="refresh">Refresh</button>

  </div>

  <script>
    const doctors = [
      {
        name: "Dr. Meena Sharma",
        department: "Cardiology",
        schedule: {
          Monday: "10:00 AM - 2:00 PM",
          Tuesday: "—",
          Wednesday: "10:00 AM - 2:00 PM",
          Thursday: "—",
          Friday: "10:00 AM - 2:00 PM",
          Saturday: "11:00 AM - 1:00 PM",
          Sunday: "—"
        }
      }
      {
        name: "Dr. Raj Patel",
        department: "Orthopedics",
        schedule: {
          Monday: "—",
          Tuesday: "9:00 AM - 1:00 PM",
          Wednesday: "—",
          Thursday: "9:00 AM - 1:00 PM",
          Friday: "—",
          Saturday: "10:00 AM - 12:00 PM",
          Sunday: "—"
        }
      },
      {
        name: "Dr. Priya Nair",
        department: "Pediatrics",
        schedule: {
          Monday: "9:00 AM - 1:00 PM",
          Tuesday: "9:00 AM - 1:00 PM",
          Wednesday: "—",
          Thursday: "9:00 AM - 1:00 PM",
          Friday: "—",
          Saturday: "—",
          Sunday: "—"
        }
      }
    ];

    function formatTime(time) {
      if (time === "—") {
        return `<span class="unavailable">NA</span>`;
      }
      return `<span class="available">${time}</span>`;
    }

    function displayDoctors() {
      const tbody = document.getElementById("doctorData");
      tbody.innerHTML = "";

      doctors.forEach(doc => {
        const row = `
          <tr>
            <td>${doc.name}</td>
            <td>${doc.department}</td>
            <td>${formatTime(doc.schedule.Monday)}</td>
            <td>${formatTime(doc.schedule.Tuesday)}</td>
            <td>${formatTime(doc.schedule.Wednesday)}</td>
            <td>${formatTime(doc.schedule.Thursday)}</td>
            <td>${formatTime(doc.schedule.Friday)}</td>
            <td>${formatTime(doc.schedule.Saturday)}</td>
            <td>${formatTime(doc.schedule.Sunday)}</td>
          </tr>
        `;
        tbody.innerHTML += row;
      });

      document.getElementById("lastUpdate").textContent =
        new Date().toLocaleString();
    }

    document.getElementById("refresh").addEventListener("click", displayDoctors);

    displayDoctors();
  </script>

</body>
</html>