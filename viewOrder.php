<?php
include "check_session.php";
include "db.php";

// ตรวจสอบว่ามี order_id ส่งมาหรือไม่
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "<div class='alert alert-danger text-center mt-4'>❌ ไม่พบหมายเลขคำสั่งซื้อ</div>";
    exit;
}

$order_id = intval($_GET['order_id']);

// ดึงข้อมูล order
$sqlOrder = "SELECT * FROM orders WHERE order_id = ?";
$stmtOrder = $conn->prepare($sqlOrder);
if (!$stmtOrder) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmtOrder->bind_param("i", $order_id);
$stmtOrder->execute();
$resultOrder = $stmtOrder->get_result();

if ($resultOrder->num_rows == 0) {
    echo "<div class='alert alert-warning text-center mt-4'>ไม่พบข้อมูลคำสั่งซื้อ</div>";
    exit;
}

$order = $resultOrder->fetch_assoc();

// ดึงรายละเอียดสินค้า
$sqlDetails = "SELECT * FROM order_details WHERE order_id = ?";
$stmtDetail = $conn->prepare($sqlDetails);
if (!$stmtDetail) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmtDetail->bind_param("i", $order_id);
$stmtDetail->execute();
$resultDetails = $stmtDetail->get_result();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดคำสั่งซื้อ #<?php echo $order_id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e3f2fd;
            font-family: "Segoe UI", Tahoma, sans-serif;
            padding: 20px 0;
        }
        .container {
            max-width: 950px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            background-color: #ffffff;
        }
        .card-header {
            background-color: #90caf9;
            color: #1e3a8a;
            font-size: 1.4rem;
            font-weight: bold;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .card-body p {
            font-size: 1rem;
            margin: 5px 0;
        }
        h5 {
            color: #1976d2;
            margin-top: 25px;
        }
        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #cfd8dc;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #64b5f6;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f1f8ff;
        }
        .summary {
            margin-top: 20px;
            font-size: 1.25rem;
            font-weight: 600;
            text-align: right;
            color: #0d47a1;
        }
        a.btn-back {
            margin-top: 20px;
            background-color: #42a5f5;
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.2s;
        }
        a.btn-back:hover {
            background-color: #1e88e5;
        }
        @media (max-width: 600px) {
            table th, table td { font-size: 0.85rem; padding: 6px; }
            .summary { font-size: 1rem; }
            a.btn-back { width: 100%; display: block; text-align: center; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header text-center">
            📦 รายละเอียดคำสั่งซื้อ #<?php echo $order_id; ?>
        </div>
        <div class="card-body">
            <p><strong>ลูกค้า:</strong> <?php echo htmlspecialchars($order['recipient_name']); ?></p>
            <p><strong>ที่อยู่จัดส่ง:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
            <p><strong>วันที่สั่งซื้อ:</strong> <?php echo $order['order_date']; ?></p>

            <h5>🛒 รายการสินค้า</h5>
            <div class="table-responsive">
                <table class="table align-middle text-center">
                    <thead>
                        <tr>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา (บาท)</th>
                            <th>จำนวน</th>
                            <th>รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($item = $resultDetails->fetch_assoc()) { 
                        $subtotal = $item['price'] * $item['quantity'];
                    ?>
                        <tr>
                            <td><?php echo $item['product_id']; ?></td>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="summary">
                ราคารวมทั้งหมด: <?php echo number_format($order['total_price'], 2); ?> บาท
            </div>

            <a href="showProduct.php" class="btn-back d-inline-block">⬅️ กลับไปเลือกซื้อสินค้า</a>
        </div>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
