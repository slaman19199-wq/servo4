<?php
$DB_SERVER = "localhost";
$DB_USER = "root";
$DB_PASS = ""; // اتركيها فاضية
$DB_NAME = "servo_db";
$conn = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>