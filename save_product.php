<?php
include "db.php";

// รับค่าจากฟอร์ม
$product_id   = $_POST['productID'];
$product_name = $_POST['product_name'];
$price        = $_POST['price'];
$detail       = $_POST['detail'];

// จัดการอัปโหลดรูปภาพ
$image_name = "";
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $image_tmp  = $_FILES['image']['tmp_name'];
    $image_name = uniqid() . "_" . $_FILES['image']['name'];
    $upload_dir = "product_image/";

    // สร้างโฟลเดอร์ถ้ายังไม่มี
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    move_uploaded_file($image_tmp, $upload_dir . $image_name);
}

// ✅ ใช้ชื่อคอลัมน์ `detail` ไม่ใช่ `details`
$sql = "INSERT INTO product (productID, product_name, price, detail, image) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("❌ เตรียมคำสั่ง SQL ไม่สำเร็จ: " . $conn->error);
}

$stmt->bind_param("ssdss", $product_id, $product_name, $price, $detail, $image_name);

if ($stmt->execute()) {
    echo "<h2 style='color:green;text-align:center;'>✅ บันทึกข้อมูลสินค้าสำเร็จ</h2>";
    echo "<p style='text-align:center;'><a href='product_form.php'>➕ เพิ่มสินค้าใหม่</a></p>";
} else {
    echo "❌ เกิดข้อผิดพลาด: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
