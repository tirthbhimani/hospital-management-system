<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $role = $_POST['role'];
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Database connection
    $con = new mysqli("localhost", "root", "", "HMS");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Select table according to role
    switch ($role) {
        case 'admin':
            $table = "admin_info";
            break;

        case 'doctor':
            $table = "doctor_info";
            break;

        case 'staff':
            $table = "staff_info";
            break;

        case 'patient':
            $table = "patient_registration";
            break;

        default:
            die("Invalid role selected");
    }

    // Prepare query
    $stmt = $con->prepare("SELECT * FROM $table WHERE username=? AND password=?");

    if (!$stmt) {
        die("Query Error: " . $con->error);
    }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    switch ($role) {
        case 'admin':
            $table = "admin_login";
            break;

        case 'doctor':
            $table = "doctor_login";
            break;

        case 'staff':
            $table = "staff_login";
            break;

        case 'patient':
            $table = "patient_login";
            break;

        default:
            die("Invalid role selected");
    }



    $stmt = $con->prepare("INSERT INTO $table(username,password) VALUES (?,?)");
    $stmt->bind_param("ss",$username,$password);

    if($stmt->execute()){
        echo "Data inserted successfully";
    }else{
        echo "Error inserting data";
    }


    // Login success
    if ($result->num_rows == 1) {

        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        if ($role == "admin") {
            header("Location: admin_home.php");
        } 
        elseif ($role == "doctor") {
            header("Location: doctor_home.php");
        } 
        elseif ($role == "staff") {
            header("Location: staff_home.php");
        } 
        elseif ($role == "patient") {
            header("Location: patient_home.php");
        }

        exit();

    } else {

        $_SESSION['login_error'] = true;
        header("Location: index.php");
        exit();

    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Change role & placeholder when button clicked
        document.addEventListener("DOMContentLoaded", () => {
            const roleInput = document.getElementById("role");
            const usernameInput = document.getElementById("username");
            const passwordInput = document.getElementById("password");

            document.querySelectorAll(".social-login button").forEach(btn => {
                btn.addEventListener("click", () => {
                    const role = btn.dataset.role;
                    roleInput.value = role;
                    usernameInput.placeholder = role.charAt(0).toUpperCase() + role.slice(1) + " Username";
                    passwordInput.placeholder = role.charAt(0).toUpperCase() + role.slice(1) + " Password";
                });
            });
        });

        
document.addEventListener("DOMContentLoaded", () => {
    const roleInput = document.getElementById("role");
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");
    const registerBox = document.getElementById("registerBox");

    document.querySelectorAll(".social-login button").forEach(btn => {
        btn.addEventListener("click", () => {
            const role = btn.dataset.role;

            roleInput.value = role;
            usernameInput.placeholder = role.charAt(0).toUpperCase() + role.slice(1) + " Username";
            passwordInput.placeholder = role.charAt(0).toUpperCase() + role.slice(1) + " Password";

            // ✅ SHOW REGISTER ONLY FOR PATIENT
            if (role === "patient") {
                registerBox.style.display = "block";
            } else {
                registerBox.style.display = "none";
            }
        });
    });
});

    </script>
</head>

<body class="container">
    <div class="form-card">
        <h2>Login</h2>
        <div class="social-login">
            <button type="button" class="btn btn-secondary" data-role="admin">Admin</button>
            <button type="button" class="btn btn-primary" data-role="doctor">Doctor</button>
            <button type="button" class="btn btn-primary" data-role="staff">Staff</button>
            <button type="button" class="btn btn-primary" data-role="patient">Patient</button>
        </div>

        <form class="loginform" method="post" action="index.php">
            <input type="hidden" id="role" name="role" value="doctor">
            <input type="text" id="username" name="username" placeholder="Doctor Username" required />
            <input type="password" id="password" name="password" placeholder="Doctor Password" required />
            <button type="submit" name="login_user">Login</button>
        </form>

        <div id="registerBox" style="text-align:center; margin-top:15px; display:none;">
        <p>New Patient?</p>
        <a href="reg.php">
        <button type="button" class="btn btn-success">Register Here</button>
    </a>
</div>
    </div>

    <?php if (isset($_SESSION['login_error'])): ?>
        <script>
            alert("Login failed! Please check your username and password.");
        </script>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

    <!-- floating background squares -->
    <div class="square" style="width:50px; height:50px; left:10%; animation-delay:0s;"></div>
    <div class="square" style="width:80px; height:80px; left:70%; animation-delay:1s;"></div>
    <div class="square" style="width:40px; height:40px; left:50%; animation-delay:2s;"></div>
    <div class="square" style="width:60px; height:60px; left:30%; animation-delay:3s;"></div>
    <div class="square" style="width:100px; height:100px; left:85%; animation-delay:4s;"></div>
</body>

</html>