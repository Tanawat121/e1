<?php
include "db.php";
session_start();

if (!isset($_GET['id'])) {
    echo "ไม่พบรหัสสินค้า";
    exit;
}

$productID = $_GET['id'];

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$sql = "SELECT * FROM product WHERE productID = '$productID'";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "ไม่พบข้อมูลสินค้านี้";
    exit;
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['product_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row">
        <div class="col-md-5">
            <img src="product_image/<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid rounded shadow-sm" alt="รูปสินค้า">
        </div>
        <div class="col-md-7">
            <h2 class="mb-3"><?php echo htmlspecialchars($product['product_name']); ?></h2>

            <p class="text-muted"><?php echo htmlspecialchars($product['detail']); ?></p>

            <ul class="list-unstyled mb-4">
                <li><strong>แหล่งผลิต:</strong> <?php echo htmlspecialchars($product['origin']); ?></li>
                <li><strong>กลิ่นรส:</strong> <?php echo htmlspecialchars($product['flavor_notes']); ?></li>
                <li><strong>ประเภท:</strong> <?php echo htmlspecialchars($product['category']); ?></li>
            </ul>

            <h4 class="text-success fw-bold">฿<?php echo number_format($product['price'], 2); ?></h4>

            <div class="mt-4">
                <a href="cart.php?action=add&id=<?php echo $product['productID']; ?>" class="btn btn-primary">🛒 หยิบใส่ตะกร้า</a>
                <a href="show_allProduct.php" class="btn btn-secondary">← กลับไปหน้าสินค้า</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
