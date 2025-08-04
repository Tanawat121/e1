<?php
    include "db.php";
    $errorMsg = '';
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        $errorMsg = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
    }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
        }

        body {
            background: linear-gradient(to right top, #fce3ec, #dfe9f3);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: white;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #7f7fd5;
            margin-bottom: 25px;
            font-size: 24px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        input[type="submit"] {
            background-color: #7f7fd5;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #5e5ec1;
        }

        .button-link {
            display: inline-block;
            margin-top: 18px;
            background-color: #64b5f6;
            color: white;
            padding: 10px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            transition: background-color 0.3s ease;
        }

        .button-link:hover {
            background-color: #42a5f5;
        }

        .error {
            color: #d32f2f;
            background-color: #ffe0e0;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <h2><i class="fa-solid fa-lock"></i> เข้าสู่ระบบ</h2>

        <?php if ($errorMsg): ?>
            <div class="error"><?= htmlspecialchars($errorMsg) ?></div>
        <?php endif; ?>

        <form method="post" action="check_login.php">
            <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
            <input type="password" name="password" placeholder="รหัสผ่าน" required>
            <input type="submit" value="เข้าสู่ระบบ">
        </form>

        <a href="register_form.html" class="button-link"><i class="fa-solid fa-user-plus"></i> สมัครสมาชิก</a>
    </div>

</body>
</html>
