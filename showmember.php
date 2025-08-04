<?php
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
include 'db.php'; // หรือ config.php แล้วแต่ชื่อไฟล์ของคุณ

// คำสั่ง SQL สำหรับดึงข้อมูลสมาชิก
$sql = "SELECT id, name, email, mobile_phone FROM customer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แสดงรายชื่อสมาชิก</title>
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f0f2f5;
            padding: 30px;
        }
        h2 {
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #4a78f7;
            color: white;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .nav-btn {
            background-color: #4a78f7;
            color: white;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .nav-btn:hover {
            background-color: #4a78f7;
        }
    </style>
</head>
<body>

<h2>รายชื่อสมาชิก</h2>

<?php
/*if (isset($_POST['back'])) {
    header("Location: register_form.html"); // หรือใส่หน้าที่ต้องการ
    exit();
}*/

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>รหัส</th><th>ชื่อ</th><th>อีเมล</th><th>เบอร์โทร</th></tr>";
    $i = 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>$i</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            </tr>";
        $i++;
}
    echo "</table>";
} else {
    echo "<p>ไม่พบข้อมูลสมาชิก</p>";
}
$conn->close();
?>

<a href="register_form.html"><button class="nav-btn">สมัครสมาชิก</button></a>
<a href="login.php"><button class="nav-btn">ล็อกอิน</button></a>

</body>
</html>
