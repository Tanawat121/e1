<?php
session_start();
include "db.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM customer WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['sess_id'] = session_id();
    $_SESSION['sess_username'] = $user['username'];
    header("Location: show_profile.php");
    exit();
} else {
    header("Location: login.php?error=1");
    exit();
}

$stmt->close();
$conn->close();
?>
