<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'connect.php';

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $first_name = sanitize_input($_POST["first_name"]);
    $last_name = sanitize_input($_POST["last_name"]);
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);
    $repeat_password = sanitize_input($_POST["repeat_password"]);
    $birthday = sanitize_input($_POST["birthday"]);
    $gender = sanitize_input($_POST["gender"]);
    $role = sanitize_input($_POST["role"]);

    $registration_date = date("Y-m-d H:i:s");

    $errors = array();

    if ($password != $repeat_password) {
        $errors[] = "Passwords do not match";
    }

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $errors[] = "Username is already in use";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (first_name, last_name, username, password, birthdate, gender, registration_date, role) 
                VALUES ('$first_name', '$last_name', '$username', '$hashed_password', '$birthday', '$gender', '$registration_date', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "User registered successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles/index-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<header class="navbar">
    <div class="logo">
        <img src="logo.png" alt="Logo">
    </div>
    <nav class="nav-links">
        <a class="login-btn" href="login.php">Login</a>
    </nav>
</header>

<section class="main-content">
    <div class="background-image">
        <div class="welcome-text">
            <h1>Welcome!</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
        </div>
        <div class="register-box">
            <header>Register</header>

<form action="" method="post">
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required><br><br>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required><br><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="repeat_password">Repeat Password:</label>
    <input type="password" id="repeat_password" name="repeat_password" required><br><br>

    <label for="birthday">Birthday:</label>
    <input type="date" id="birthday" name="birthday" required><br><br>

    <label for="gender">Gender:</label>
    <input type="radio" id="male" name="gender" value="male" required>
    <label for="male">Male</label>
    <input type="radio" id="female" name="gender" value="female" required>
    <label for="female">Female</label><br><br>

    <input type="hidden" id="role" name="role" value="patient">

    <input type="submit" value="Register">
</form>
            <p>Already have an account? <a href="#">Login</a></p>
        </div>
    </div>
</section>

<footer class="footer">
    <p>Contact Information</p>
</footer>

</body>
</html>
