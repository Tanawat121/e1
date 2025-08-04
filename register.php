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
$success = false;
$message = "";

if ($stmt_obj->execute()) {
    $success = true;
    $message = "✅ สมัครสมาชิกสำเร็จ!";
} else {
    $message = "❌ เกิดข้อผิดพลาด: " . $stmt_obj->error;
}

// 5. ปิดการเชื่อมต่อ
$stmt_obj->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผลการสมัครสมาชิก</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
        }

        body {
            background: linear-gradient(to right top, #fce3ec, #dfe9f3);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .message-box {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 450px;
            width: 100%;
        }

        .message-box h2 {
            font-size: 24px;
            color: <?= $success ? "#4caf50" : "#e53935" ?>;
            margin-bottom: 20px;
        }

        .message-box p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #333;
        }

        .message-box a {
            text-decoration: none;
        }

        .message-box button {
            background-color: #7f7fd5;
            color: white;
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .message-box button:hover {
            background-color: #5e5ec1;
        }
    </style>
</head>
<body>

    <div class="message-box">
        <h2><?= $success ? "🎉 สมัครสมาชิกสำเร็จ" : "เกิดข้อผิดพลาด" ?></h2>
        <p><?= htmlspecialchars($message) ?></p>
        <a href="login.php">
            <button><i class="fa-solid fa-right-to-bracket"></i> ไปยังหน้าเข้าสู่ระบบ</button>
        </a>
    </div>

</body>
</html>
