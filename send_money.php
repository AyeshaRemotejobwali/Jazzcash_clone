<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient = $_POST['recipient'];
    $amount = $_POST['amount'];
    $pin = $_POST['pin'];
    $stmt = $conn->prepare("SELECT pin, balance FROM users u JOIN wallet w ON u.id = w.user_id WHERE u.id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    if (password_verify($pin, $user['pin']) && $user['balance'] >= $amount) {
        $conn->beginTransaction();
        try {
            $stmt = $conn->prepare("UPDATE wallet SET balance = balance - ? WHERE user_id = ?");
            $stmt->execute([$amount, $user_id]);
            $stmt = $conn->prepare("INSERT INTO transactions (user_id, type, amount, recipient, status) VALUES (?, 'transfer', ?, ?, 'completed')");
            $stmt->execute([$user_id, $amount, $recipient]);
            $conn->commit();
            echo "<script>alert('Transfer successful!'); window.location.href='dashboard.php';</script>";
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid PIN or insufficient balance');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Money - JazzCash Clone</title>
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
        <h2>Send Money</h2>
        <form method="POST">
            <div class="form-group">
                <label for="recipient">Recipient (Phone/IBAN)</label>
                <input type="text" id="recipient" name="recipient" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount (PKR)</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="pin">PIN</label>
                <input type="password" id="pin" name="pin" maxlength="4" required>
            </div>
            <button type="submit" class="btn">Send</button>
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
