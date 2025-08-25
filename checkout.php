<?php
session_start();

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ยืนยันการสั่งซื้อ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center">🧾 ยืนยันคำสั่งซื้อ</h2>

    <table class="table table-bordered text-center bg-white">
        <thead class="table-secondary">
            <tr>
                <th>ชื่อสินค้า</th>
                <th>จำนวน</th>
                <th>ราคาต่อหน่วย</th>
                <th>ราคารวม</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $item):
                $sum = $item['price'] * $item['qty'];
                $total += $sum;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo $item['qty']; ?></td>
                <td>฿<?php echo number_format($item['price'], 2); ?></td>
                <td>฿<?php echo number_format($sum, 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="fw-bold bg-light">
                <td colspan="3" class="text-end">รวมทั้งหมด</td>
                <td>฿<?php echo number_format($total, 2); ?></td>
            </tr>
        </tbody>
    </table>

    <!-- ปุ่มยืนยัน -->
    <div class="text-center mt-4">
        <form action="checkout_process.php" method="post">
            <button type="submit" class="btn btn-success btn-lg">✅ ยืนยันการสั่งซื้อ</button>
            <a href="cart.php" class="btn btn-secondary ms-2">← กลับไปตะกร้า</a>
        </form>
    </div>
</div>

</body>
</html>
