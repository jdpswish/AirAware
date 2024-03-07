<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../connect.php'; 
    $username = $_POST["username"];
    $password = $_POST["password"];
    $admincode = $_POST["admincode"];

    $sql = "SELECT password, admincode FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_password, $db_admincode);
    $stmt->fetch();
    $stmt->close();

    if ($password == $db_password && $admincode == $db_admincode) { 

        $_SESSION["username"] = $username;
        header("Location: admin-dashboard.php");
        exit;
    
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
    <link rel="stylesheet" href="../styles/login-style.css">

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
                <a href="../login.php"><button class="btnLogin-popup">User Login</button></a>
            </nav>
        </h2>
    </header>

    <div class="error-message"><?php echo isset($error_message) ? $error_message : ''; ?></div>

    <div class="wrapper">
        <div class="form-box login">
            <h2><i class="fa-solid fa-user-tie"></i> Admin Login</h2>
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
                <div class="input-box">
                    <span class="icon"> 
                        <i class="fa-solid fa-code"></i> 
                    </span>
                    <input type="password" id="admincode" name="admincode" required>
                    <label for="admincode">Admin Code</label>
                </div>
                <button type="submit" class="btn"> Sign In </button>
            </form>
        </div>
    </div>   
    <script>
</body>
</html>
