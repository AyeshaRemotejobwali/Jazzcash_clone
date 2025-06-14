<?php
require_once 'db.php';
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JazzCash Clone - Home</title>
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
        header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .services {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }
        .service-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 200px;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s;
        }
        .service-card:hover {
            transform: translateY(-5px);
        }
        .service-card img {
            width: 50px;
            height: 50px;
        }
        .service-card h3 {
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
            margin: 10px;
        }
        .btn:hover {
            background: #ff5e62;
        }
        @media (max-width: 600px) {
            .service-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>JazzCash Clone</h1>
            <p>Your one-stop digital payment solution</p>
        </header>
        <div class="services">
            <div class="service-card">
                <img src="https://via.placeholder.com/50" alt="Send Money">
                <h3>Send Money</h3>
                <p>Transfer funds instantly to anyone.</p>
                <a href="#" onclick="redirectTo('login.php')" class="btn">Get Started</a>
            </div>
            <div class="service-card">
                <img src="https://via.placeholder.com/50" alt="Bill Payment">
                <h3>Pay Bills</h3>
                <p>Pay utility bills with ease.</p>
                <a href="#" onclick="redirectTo('login.php')" class="btn">Pay Now</a>
            </div>
            <div class="service-card">
                <img src="https://via.placeholder.com/50" alt="Mobile Recharge">
                <h3>Mobile Recharge</h3>
                <p>Top-up mobile accounts instantly.</p>
                <a href="#" onclick="redirectTo('login.php')" class="btn">Recharge</a>
            </div>
            <div class="service-card">
                <img src="https://via.placeholder.com/50" alt="Add Balance">
                <h3>Add Balance</h3>
                <p>Deposit funds to your wallet.</p>
                <a href="#" onclick="redirectTo('login.php')" class="btn">Add Now</a>
            </div>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="#" onclick="redirectTo('signup.php')" class="btn">Sign Up</a>
            <a href="#" onclick="redirectTo('login.php')" class="btn">Log In</a>
        </div>
    </div>
    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
