<?php
include "db.php";
// ----- ดึงข้อมูลจากตาราง product -----
$sql = "SELECT productID, product_name, origin, flavor_notes, category, price, detail, image FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สินค้า</title>
    <!-- ใช้ Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .text-brown {
        color: #8B4513; /* สีน้ำตาล */
    }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4 text-center">รายการสินค้า</h1>
    <div class="row g-4">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
        ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm">
                <img src="product_image/<?php echo htmlspecialchars($row['image']); ?>" 
                    class="card-img-top" 
                    alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                <div class="card-body d-flex flex-column">
                    <!-- ชื่อสินค้า -->
                    <h5 class="card-title fw-bold text-brown">
                        <?php echo htmlspecialchars($row['product_name']); ?>
                    </h5>

                    <!-- รายละเอียด -->
                    <p class="card-text small mb-2"><?php echo htmlspecialchars($row['detail']); ?></p>

                    <!-- ข้อมูลอื่น ๆ -->
                    <p class="card-text mb-1">
                        <span class="fw-bold">แหล่งผลิต:</span> <?php echo htmlspecialchars($row['origin']); ?>
                    </p>
                    <p class="card-text mb-1">
                        <span class="fw-bold">กลิ่นรส:</span> <?php echo htmlspecialchars($row['flavor_notes']); ?>
                    </p>
                    <p class="card-text mb-1">
                        <span class="fw-bold">ประเภท:</span> <?php echo htmlspecialchars($row['category']); ?>
                    </p>

                    <!-- ราคา (สลับมาหลังรายละเอียด) -->
                    <p class="fw-bold text-success mb-2">
                        ฿<?php echo number_format($row['price'], 2); ?>
                    </p>

                    <!-- ปุ่ม CTA -->
                    <div class="mt-auto">
                        <a href="cart.php?action=add&id=<?php echo $row['productID']; ?>" 
                        class="btn btn-primary w-100">
                        🛒 หยิบใส่ตะกร้า
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<p class='text-center'>ยังไม่มีสินค้า</p>";
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>