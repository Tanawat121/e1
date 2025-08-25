<?php
session_start();

// ในระบบจริงจะบันทึกคำสั่งซื้อในฐานข้อมูลตรงนี้

// ล้างตะกร้า
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สั่งซื้อสำเร็จ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5 text-center">
    <h2 class="text-success mb-4">✅ สั่งซื้อเรียบร้อยแล้ว</h2>
    <p class="text-muted">ขอบคุณที่ใช้บริการ</p>
    <a href="show_allProduct.php" class="btn btn-primary mt-3">กลับไปเลือกสินค้า</a>
</div>

</body>
</html>
