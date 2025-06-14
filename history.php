<?php
require_once 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - JazzCash Clone</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f12711;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #f12711;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #ff5e62;
        }
        @media (max-width: 600px) {
            table {
                font-size: 14px;
            }
            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Transaction History</h1>
        </header>
        <table>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Amount (PKR)</th>
                <th>Recipient</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?php echo $transaction['id']; ?></td>
                <td><?php echo ucfirst($transaction['type']); ?></td>
                <td><?php echo number_format($transaction['amount'], 2); ?></td>
                <td><?php echo $transaction['recipient'] ?: 'N/A'; ?></td>
                <td><?php echo ucfirst($transaction['status']); ?></td>
                <td><?php echo $transaction['created_at']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div style="text-align: center;">
            <a href="#" onclick="redirectTo('dashboard.php')" class="btn">Back to Dashboard</a>
        </div>
    </div>
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
