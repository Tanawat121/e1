<?php
// 1. เชื่อมต่อฐานข้อมูล
include "db.php";

// 2. รับค่าจากฟอร์ม
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$email = $_POST['email'];
$mobile_phone = $_POST['mobile_phone'];
$address = $_POST['address'];

// ✅ เข้ารหัสรหัสผ่านก่อนบันทึก
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 3. เตรียมคำสั่ง SQL
$sql = "INSERT INTO customer (username, password, name, email, phone, address) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt_obj = $conn->prepare($sql);
$stmt_obj->bind_param("ssssss", $username, $hashed_password, $name, $email, $mobile_phone, $address);

// 4. ตรวจสอบการประมวลผลคำสั่ง SQL
if ($stmt_obj->execute()) {
    echo "✅ คุณสมัครสมาชิกเรียบร้อยแล้ว";
} else {
    echo "❌ เกิดข้อผิดพลาดในการสมัคร: " . $stmt_obj->error;
}

// 5. ปิดการเชื่อมต่อ
$stmt_obj->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="mycss.css">
</head>
<body>
    <hr>
    <a href="login.php">
    <button>ล็อกอิน</button>
    </a>
</body>
</html>