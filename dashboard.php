<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/dashboard.css">
</head>

<body>
    <div class="dashboard">
        <h1>Welcome to Olu's Kitchen Dashboard</h1>
        <p>Hello, <?php echo htmlspecialchars($username); ?>!</p>
    </div>
</body>

</html>
