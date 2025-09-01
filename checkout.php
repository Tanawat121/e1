<?php
include "check_session.php"; // ตรวจสอบ login
include "db.php";

$user_login = $_SESSION['sess_username'];

// ตรวจสอบว่ามีสินค้าในตะกร้า
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['products'])) {

    // ดึงข้อมูลลูกค้า
    $sqlCustomer = "SELECT * FROM customer WHERE username = ?";
    $stmtCus = $conn->prepare($sqlCustomer);
    $stmtCus->bind_param("s", $user_login);
    $stmtCus->execute();
    $resultCus = $stmtCus->get_result();

    if ($resultCus->num_rows == 0) {
        header("Location: login_form.php");
        exit;
    }

    $customer = $resultCus->fetch_assoc();
    $customer_id     = $customer['id'];
    $recipient_name   = $customer['name'];
    $shipping_address = $customer['address'];
    $order_date = date("Y-m-d");

    $conn->begin_transaction();

    try {
        // 1) บันทึก orders
        $sqlOrder = "INSERT INTO orders (customer_id, recipient_name, shipping_address, order_date, total_price)
                     VALUES (?, ?, ?, ?, ?)";
        $stmtOrder = $conn->prepare($sqlOrder);

        // คำนวณราคาจริงจาก DB
        $total_price = 0;
        foreach ($_POST['products'] as $product) {
            $product_id = $product['productID'];
            $qty = max(1, (int)$product['qty']);

            $price_sql = "SELECT price, product_name FROM product WHERE productID = ?";
            $price_stmt = $conn->prepare($price_sql);
            $price_stmt->bind_param("s", $product_id);
            $price_stmt->execute();
            $price_stmt->bind_result($real_price, $real_name);
            $price_stmt->fetch();
            $price_stmt->close();

            $total_price += $real_price * $qty;
        }

        $stmtOrder->bind_param("isssd", $customer_id, $recipient_name, $shipping_address, $order_date, $total_price);
        $stmtOrder->execute();
        $order_id = $stmtOrder->insert_id;

        // 2) บันทึกรายละเอียดสินค้า
        $sqlDetail = "INSERT INTO order_details (order_id, product_id, product_name, price, quantity)
                      VALUES (?, ?, ?, ?, ?)";
        $stmtDetail = $conn->prepare($sqlDetail);

        foreach ($_POST['products'] as $product) {
            $product_id = $product['productID'];
            $qty = max(1, (int)$product['qty']);

            $price_sql = "SELECT price, product_name FROM product WHERE productID = ?";
            $price_stmt = $conn->prepare($price_sql);
            $price_stmt->bind_param("s", $product_id);
            $price_stmt->execute();
            $price_stmt->bind_result($real_price, $real_name);
            $price_stmt->fetch();
            $price_stmt->close();

            $stmtDetail->bind_param("issdi", $order_id, $product_id, $real_name, $real_price, $qty);
            $stmtDetail->execute();
        }

        $conn->commit();
        unset($_SESSION['cart']); // ล้างตะกร้า
        ?>

        <!DOCTYPE html>
        <html lang="th">
        <head>
            <meta charset="UTF-8">
            <title>สั่งซื้อเรียบร้อยแล้ว</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { background-color: #f8f9fa; font-family: Tahoma; }
                .order-box { max-width: 600px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
                .order-box h2 { color: #28a745; }
                .order-box a.btn { margin-top: 15px; }
            </style>
        </head>
        <body>
        <div class="order-box text-center">
            <h2>✅ สั่งซื้อเรียบร้อยแล้ว</h2>
            <p>หมายเลขคำสั่งซื้อของคุณคือ <br>
                <strong>
                    <a href="viewOrder.php?order_id=<?php echo $order_id; ?>" class="btn btn-outline-primary">#<?php echo $order_id; ?></a>
                </strong>
            </p>
            <a href="showProduct.php" class="btn btn-success">🛒 กลับไปเลือกซื้อสินค้า</a>
        </div>
        </body>
        </html>

        <?php
    } catch (Exception $e) {
        $conn->rollback();
        echo "<div class='alert alert-danger'>❌ เกิดข้อผิดพลาด: " . $e->getMessage() . "</div>";
    }

} else {
    echo "<div class='alert alert-warning'>คุณยังไม่ได้เลือกสินค้า <a href='showProduct.php'>เลือกสินค้า</a></div>";
}

$conn->close();
?>
