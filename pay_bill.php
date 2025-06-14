<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bill_type = $_POST['bill_type'];
    $bill_reference = $_POST['bill_reference'];
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
            $stmt = $conn->prepare("INSERT INTO bills (user_id, bill_type, amount, bill_reference, status) VALUES (?, ?, ?, ?, 'paid')");
            $stmt->execute([$user_id, $bill_type, $amount, $bill_reference]);
            $conn->commit();
            echo "<script>alert('Bill paid successfully!'); window.location.href='dashboard.php';</script>";
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
    <title>Pay Bill - JazzCash Clone</title>
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
        .form-group input, .form-group select {
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
        <h2>Pay Bill</h2>
        <form method="POST">
            <div class="form-group">
                <label for="bill_type">Bill Type</label>
                <select id="bill_type" name="bill_type" required>
                    <option value="electricity">Electricity</option>
                    <option value="gas">Gas</option>
                    <option value="water">Water</option>
                    <option value="internet">Internet</option>
                    <option value="mobile">Mobile</option>
                </select>
            </div>
            <div class="form-group">
                <label for="bill_reference">Bill Reference</label>
                <input type="text" id="bill_reference" name="bill_reference" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount (PKR)</label>
                <input type="number" id="amount" name="amount" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="pin">PIN</label>
                <input type="password" id="pin" name="pin" maxlength="4" required>
            </div>
            <button type="submit" class="btn">Pay Bill</button>
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
