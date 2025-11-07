<?php
include 'db.php';

if(isset($_POST['s1']) && isset($_POST['s2']) && isset($_POST['s3']) && isset($_POST['s4'])) {
    $s1 = $_POST['s1'];
    $s2 = $_POST['s2'];
    $s3 = $_POST['s3'];
    $s4 = $_POST['s4'];

    $sql = "INSERT INTO servo_positions (s1, s2, s3, s4) VALUES ('$s1','$s2','$s3','$s4')";
    if ($conn->query($sql) === TRUE) {
        echo "Position saved successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>