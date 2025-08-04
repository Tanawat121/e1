<?php
    include "check_session.php";
    $sess_username = $_SESSION['sess_username'];
    $sess_id = $_SESSION['sess_id'];

    include "db.php";
    $sql = "SELECT * FROM customer WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sess_username);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer_data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลส่วนตัว</title>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Prompt', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(to right top, #e0d8ff, #f3e9ff);
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header-bar {
            background: linear-gradient(to right, #7f7fd5, #86a8e7, #91eae4);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 22px;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logout-button {
            background-color: #ff6b81;
            padding: 10px 18px;
            border-radius: 8px;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #e63946;
        }

        .content-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 20px;
        }

        .profile-card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            border: 2px solid #e1d3ff;
        }

        .profile-title {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            color: #7f7fd5;
        }

        .profile-item {
            margin-bottom: 22px;
            display: flex;
            align-items: flex-start;
        }

        .profile-icon {
            color: #a78bfa;
            margin-right: 15px;
            font-size: 18px;
            margin-top: 3px;
        }

        .profile-label {
            font-weight: 600;
            color: #555;
            font-size: 15px;
        }

        .profile-value {
            color: #333;
            font-size: 16px;
            margin-top: 3px;
        }

        .no-data {
            text-align: center;
            color: #999;
            font-size: 1.2em;
        }
    </style>
</head>
<body>

    <div class="header-bar">
        <div><i class="fa-solid fa-user"></i> ข้อมูลส่วนตัว: <?php echo htmlspecialchars($customer_data ? $customer_data['name'] : $sess_username); ?></div>
        <a href="logout.php" class="logout-button"><i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ</a>
    </div>

    <div class="content-container">
        <?php if ($customer_data): ?>
        <div class="profile-card">
            <div class="profile-title"><i class="fa-solid fa-id-card"></i> รายละเอียดผู้ใช้งาน</div>

            <div class="profile-item">
                <div class="profile-icon"><i class="fa-solid fa-user"></i></div>
                <div>
                    <div class="profile-label">ชื่อเข้าใช้งาน:</div>
                    <div class="profile-value"><?php echo htmlspecialchars($customer_data['username']); ?></div>
                </div>
            </div>

            <div class="profile-item">
                <div class="profile-icon"><i class="fa-solid fa-address-card"></i></div>
                <div>
                    <div class="profile-label">ชื่อ - นามสกุล:</div>
                    <div class="profile-value"><?php echo htmlspecialchars($customer_data['name']); ?></div>
                </div>
            </div>

            <div class="profile-item">
                <div class="profile-icon"><i class="fa-solid fa-envelope"></i></div>
                <div>
                    <div class="profile-label">Email:</div>
                    <div class="profile-value"><?php echo htmlspecialchars($customer_data['email']); ?></div>
                </div>
            </div>

            <div class="profile-item">
                <div class="profile-icon"><i class="fa-solid fa-phone"></i></div>
                <div>
                    <div class="profile-label">เบอร์โทรศัพท์:</div>
                    <div class="profile-value"><?php echo htmlspecialchars($customer_data['phone']); ?></div>
                </div>
            </div>

            <div class="profile-item">
                <div class="profile-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div>
                    <div class="profile-label">ที่อยู่จัดส่ง:</div>
                    <div class="profile-value"><?php echo htmlspecialchars($customer_data['address']); ?></div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <p class="no-data">ไม่พบข้อมูลส่วนตัวสำหรับผู้ใช้นี้</p>
        <?php endif; ?>
    </div>

</body>
</html>
