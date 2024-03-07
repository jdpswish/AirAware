<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'connect.php'; 
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT id, password, first_name, last_name, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $first_name, $last_name, $role);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashed_password)) {
        $_SESSION["user_id"] = $user_id;
        $_SESSION["first_name"] = $first_name;
        $_SESSION["last_name"] = $last_name;

        if($role == 'patient') {
            header("Location: patient-dashboard.php");
            exit;
        } elseif($role == 'doctor' || $role == 'staff') {
            header("Location: doctorstaff-dashboard.php");
            exit;
        }
    } else {
        $error_message = "Invalid Credentials";
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/login-style.css">

</head>
<body>
    <script src="https://kit.fontawesome.com/ec9954c9b8.js" crossorigin="anonymous"></script>
    <header class="header">
        <div class="logo"> 
            <img src="C:\xampp\htdocs\webserver\MAIN LOGO TRANSPARENT.png" alt="Logo">
        </div>
        <h2 class="navigation"> 
            <nav> 
                <a href="#">Home</a>
                <a href="#">About Us</a>
                <a href="#">Contact</a>
                <a href="index.php"><button class="btnLogin-popup">Register</button></a>
            </nav>
        </h2>
    </header>

    <div class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>

    <div class="wrapper">
        <div class="form-box login">
            <h2><i class="fa-solid fa-users"></i>     Login</h2>
            <br> 
            <form class="" method="POST">
                <div class="input-box">
                    <span class="icon"> 
                    <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" id="username" name="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"> 
                        <i class="fa-solid fa-lock"></i> 
                    </span>
                    <input type="password" id="password" name="password" required>
                    <label for="password">Password</label>
                </div>
                <div class="remember-forgot">
                    <a href="#"> Forgot Password? </a>
                </div>
                <button type="submit" class="btn"> Sign In </button>
            </form>
        </div>
    </div>   
    <script>
</body>
</html>
