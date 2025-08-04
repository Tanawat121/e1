<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลสินค้า</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
        }

        body {
            margin: 0;
            background: linear-gradient(to right top, #f3f4f6, #e0f7fa);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 40px 15px;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 16px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #3f51b5;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        input[readonly] {
            background-color: #f2f2f2;
            cursor: not-allowed;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3f51b5;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #303f9f;
        }

        @media screen and (max-width: 480px) {
            .form-container {
                padding: 20px;
            }

            h2 {
                font-size: 20px;
            }

            button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

    <form class="form-container" action="save_product.php" method="post" enctype="multipart/form-data">
        <h2>เพิ่มข้อมูลสินค้า</h2>

        <label for="productID">รหัสสินค้า (Product ID):</label>
        <input type="text" name="productID" id="productID" readonly required>

        <label for="product_name">ชื่อสินค้า:</label>
        <input type="text" name="product_name" id="product_name" required>

        <label for="price">ราคา (บาท):</label>
        <input type="number" name="price" id="price" step="0.01" required>

        <label for="detail">รายละเอียดสินค้า:</label>
        <textarea name="detail" id="detail" rows="4" required></textarea>

        <label for="image">รูปภาพสินค้า:</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <button type="submit">บันทึกสินค้า</button>
    </form>

    <script>
        // สร้างรหัสสินค้าแบบสุ่ม
        function generateProductID() {
            const now = new Date();
            const datePart = `${now.getFullYear()}${(now.getMonth()+1).toString().padStart(2, '0')}${now.getDate().toString().padStart(2, '0')}`;
            const randomPart = Math.floor(1000 + Math.random() * 9000); // 4 หลัก
            return `P${datePart}${randomPart}`;
        }

        // เติมค่าในช่อง productID
        document.getElementById('productID').value = generateProductID();
    </script>

</body>
</html>
