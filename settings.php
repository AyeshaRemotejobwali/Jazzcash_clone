<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_pin = password_hash($_POST['new_pin'], PASSWORD_BCRYPT);
    $current_pin = $_POST['current_pin'];
    $stmt = $conn->prepare("SELECT pin FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    if (password_verify($current_pin, $user['pin'])) {
        $stmt = $conn->prepare("UPDATE users SET pin = ? WHERE id = ?");
        $stmt->execute([$new_pin, $user_id]);
        echo "<script>alert('PIN updated successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid current PIN');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - JazzCash Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f12711, #ff5e62);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .form-container h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background: #f12711;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #ff5e62;
        }
        .back {
            text-align: center;
            margin-top: 10px;
        }
        .back a {
            color: #f12711;
            text-decoration: none;
        }
        .back a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Account Settings</h2>
        <form method="POST">
            <div class="form-group">
                <label for="current_pin">Current PIN</label>
                <input type="password" id="current_pin" name="current_pin" maxlength="4" required>
            </div>
            <div class="form-group">
                <label for="new_pin">New PIN</label>
                <input type="password" id="new_pin" name="new_pin" maxlength="4" required>
            </div>
            <button type="submit" class="btn">Update PIN</button>
        </form>
        <div class="back">
            <a href="#" onclick="redirectTo('dashboard.php')">Back to Dashboard</a>
        </div>
    </div>
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
