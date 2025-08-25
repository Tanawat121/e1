<?php
include "db.php";
session_start();

$sql = "SELECT * FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center">สินค้า</h2>
    <div class="row g-4">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <img src="product_image/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['product_name']); ?></h5>
                        <p class="card-text text-muted small"><?php echo htmlspecialchars($row['detail']); ?></p>
                        <p class="fw-bold text-success">฿<?php echo number_format($row['price'], 2); ?></p>
                        <a href="cart.php?action=add&id=<?php echo $row['productID']; ?>" class="btn btn-primary mt-auto">🛒 หยิบใส่ตะกร้า</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">ไม่มีสินค้า</p>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <a href="cart.php" class="btn btn-success">ดูตะกร้าสินค้า</a>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
