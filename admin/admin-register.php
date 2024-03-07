<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../connect.php';

    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);
    $admin_code = sanitize_input($_POST["admin_code"]);

    $registration_date = date("Y-m-d H:i:s");

    $errors = array();

    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $errors[] = "Username is already in use";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO admin (username, password, admin_code) 
                VALUES ('$username', '$hashed_password', '$admin_code')";

        if ($conn->query($sql) === TRUE) {
            echo "Admin registered successfully";
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
    <title>Admin Registration</title>
    <link rel="stylesheet" href="styles/registration-style.css">
</head>
<body>
    <header class="header">
        <h1>Admin Registration</h1>
    </header>
    <div class="container">
        <form action="admin-register.php" method="post">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="admin_code">Admin Code:</label>
                <input type="password" id="admin_code" name="admin_code" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html> 
