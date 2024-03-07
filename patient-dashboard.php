<?php
session_start();

if (isset($_SESSION["first_name"]) && isset($_SESSION["last_name"])) {
    $first_name = $_SESSION["first_name"];
    $last_name = $_SESSION["last_name"];
    echo "Welcome, $first_name $last_name!";
} else {
    header("Location: login.php");
    exit;
}
