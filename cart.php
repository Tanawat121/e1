<?php
session_start();
include "db.php";

// ตรวจสอบ action
if (isset($_GET['action']) && $_GET['action'] == "add") {
    if (isset($_GET['id'])) {
        $productID = $conn->real_escape_string($_GET['id']);

        // ดึงข้อมูลสินค้าจากฐานข้อมูล
        $sql = "SELECT productID, product_name, price FROM product WHERE productID = '$productID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();

            // ถ้า session cart ยังไม่ถูกสร้าง ให้สร้าง
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // ถ้ามีสินค้าอยู่แล้วในตะกร้า → เพิ่มจำนวน
            if (isset($_SESSION['cart'][$productID])) {
                $_SESSION['cart'][$productID]['qty'] += 1;
            } else {
                // ถ้ายังไม่มีสินค้า → เพิ่มใหม่
                $_SESSION['cart'][$productID] = [
                    "productID" => $product['productID'],
                    "name"      => $product['product_name'],
                    "price"     => $product['price'],
                    "qty"       => 1
                ];
            }
        }
    }

    header("Location: cart.php");
    exit;
}

// ถ้ากดลบสินค้าออกจากตะกร้า
if (isset($_GET['action']) && $_GET['action'] == "remove") {
    if (isset($_GET['id']) && isset($_SESSION['cart'][$_GET['id']])) {
        unset($_SESSION['cart'][$_GET['id']]);
    }
    header("Location: cart.php");
    exit;
}

// ถ้าล้างตะกร้า
if (isset($_GET['action']) && $_GET['action'] == "clear") {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตะกร้าสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">🛒 ตะกร้าสินค้า</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <form action="checkout.php" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>รหัสสินค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>ราคา</th>
                        <th>จำนวน</th>
                        <th>ราคารวม</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $index => $item):
                        $subtotal = $item['price'] * $item['qty'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($item['productID']); ?>
                            <input type="hidden" name="products[<?php echo $index; ?>][productID]" value="<?php echo $item['productID']; ?>">
                        </td>
                        <td>
                            <a href="view_product.php?product_id=<?php echo urlencode($item['productID']); ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($item['name']); ?>
                            </a>
                            <input type="hidden" name="products[<?php echo $index; ?>][name]" value="<?php echo htmlspecialchars($item['name']); ?>">
                        </td>
                        <td>
                            ฿<?php echo number_format($item['price'], 2); ?>
                            <input type="hidden" name="products[<?php echo $index; ?>][price]" value="<?php echo $item['price']; ?>">
                        </td>
                        <td>
                            <?php echo $item['qty']; ?>
                            <input type="hidden" name="products[<?php echo $index; ?>][qty]" value="<?php echo $item['qty']; ?>">
                        </td>
                        <td>฿<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <a href="cart.php?action=remove&id=<?php echo $item['productID']; ?>" class="btn btn-danger btn-sm">ลบ</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">รวมทั้งหมด</td>
                        <td colspan="2" class="fw-bold">฿<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="total" value="<?php echo $total; ?>">

            <div class="d-flex justify-content-between">
                <a href="showProduct.php" class="btn btn-secondary">⬅️ กลับไปเลือกซื้อสินค้า</a>
                <div>
                    <a href="cart.php?action=clear" class="btn btn-warning">ล้างตะกร้า</a>
                    <button type="submit" class="btn btn-success">สั่งซื้อสินค้า</button>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-info">ยังไม่มีสินค้าในตะกร้า</div>
        <a href="showProduct.php" class="btn btn-secondary mt-3">⬅️ กลับไปเลือกซื้อสินค้า</a>
    <?php endif; ?>
</div>
</body>
</html>

<?php $conn->close(); ?>
