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
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 320px;
        }
        .login-box h2 {
            text-align: center;
            color: #333;
        }
        .login-box input[type="text"],
        .login-box input[type="password"],
        .login-box input[type="submit"],
        .login-box a.button-link {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            display: block;
            text-align: center;
        }
        input[type="text"], input[type="password"] {
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        a.button-link {
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
        }
        a.button-link:hover {
            background-color: #3b7dd8;
        }
        .error {
            color: red;
            background-color: #ffe0e0;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-box">
    <?php if ($errorMsg): ?>
        <p style='color:red;'><?= htmlspecialchars($errorMsg) ?></p>
    <?php endif; ?>

    <h2>เข้าสู่ระบบ</h2>
        <form method="post" action="check_login.php">
            <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
            <input type="password" name="password" placeholder="รหัสผ่าน" required>
            <input type="submit" value="เข้าสู่ระบบ">
            <?php if (!empty($error)) : ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>  
        </form>

    <a href="register_form.html" class="button-link">สมัครสมาชิก</a>
</div>




</body>
</html>
