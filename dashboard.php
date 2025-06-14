<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT balance FROM wallet WHERE user_id = ?");
$stmt->execute([$user_id]);
$wallet = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - JazzCash Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background: linear-gradient(90deg, #ff5e62, #f12711);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        }
        .balance {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .balance h2 {
            margin: 0;
            color: #333;
        }
        .options {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .option-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 200px;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s;
        }
        .option-card:hover {
            transform: translateY(-5px);
        }
        .option-card h3 {
            margin: 10px 0;
            color: #333;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #f12711;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background: #ff5e62;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        @media (max-width: 600px) {
            .option-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to JazzCash Clone</h1>
        </header>
        <div class="balance">
            <h2>Wallet Balance: PKR <?php echo number_format($wallet['balance'], 2); ?></h2>
        </div>
        <div class="options">
            <div class="option-card">
                <h3>Add Balance</h3>
                <a href="#" onclick="redirectTo('add_balance.php')" class="btn">Add Now</a>
            </div>
            <div class="option-card">
                <h3>Send Money</h3>
                <a href="#" onclick="redirectTo('send_money.php')" class="btn">Send Now</a>
            </div>
            <div class="option-card">
                <h3>Pay Bills</h3>
                <a href="#" onclick="redirectTo('pay_bill.php')" class="btn">Pay Now</a>
            </div>
            <div class="option-card">
                <h3>Mobile Recharge</h3>
                <a href="#" onclick="redirectTo('recharge.php')" class="btn">Recharge</a>
            </div>
            <div class="option-card">
                <h3>Transaction History</h3>
                <a href="#" onclick="redirectTo('history.php')" class="btn">View</a>
            </div>
            <div class="option-card">
                <h3>Account Settings</h3>
                <a href="#" onclick="redirectTo('settings.php')" class="btn">Manage</a>
            </div>
        </div>
        <div class="logout">
            <a href="#" onclick="redirectTo('logout.php')" class="btn">Log Out</a>
        </div>
    </div>
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
