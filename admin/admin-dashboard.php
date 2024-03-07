<?php
session_start();

if (isset($_SESSION["username"]) ) {
    $username = $_SESSION["username"];

    echo "Welcome, Admin";

} else {
    header("Location: adminlogin.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles/admin-dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="#" onclick="loadSection('patients')">Patients</a></li>
            <li><a href="#" onclick="loadSection('staff'); event.preventDefault();">Staff/Doctors</a></li>
            <li><a href="#" onclick="loadSection('logs')">Logs</a></li>
        </ul>
    </div>

    <div class="content" id="dashboardContent">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>Select a section from the sidebar to get started.</p>
    </div>

    <script>
        function loadSection(section) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("dashboardContent").innerHTML = this.responseText;
                    highlightNavItem(section);
                }
            };
            xhttp.open("GET", section === 'patients' ? "patients.php" : section === 'staff' ? "sd.php" : "logs.php", true);
            xhttp.send();
        }

        function highlightNavItem(section) {
            var navItems = document.querySelectorAll(".sidebar ul li a");
            navItems.forEach(item => {
                item.classList.remove("active");
            });
            document.querySelector(".sidebar ul li:nth-child(" + (section === 'patients' ? 1 : section === 'staff' ? 2 : 3) + ") a").classList.add("active");
        }
    </script>
</body>
</html>
