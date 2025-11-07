<?php
include 'db.php';
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT * FROM servo_positions ORDER BY id DESC");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>