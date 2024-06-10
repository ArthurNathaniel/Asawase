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
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var now = new Date();
            var hours = now.getHours();
            var greeting;

            if (hours < 12) {
                greeting = "Good morning";
            } else if (hours < 18) {
                greeting = "Good afternoon";
            } else {
                greeting = "Good evening";
            }

            document.getElementById("greeting").innerText = greeting + ", <?php echo htmlspecialchars($username); ?>";
        });
    </script>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="dashboard">
        <div class="swiper_dashboard">
            <div class="s_text">
            <h1 id="greeting"></h1>
            <p>Welcome to Asawase St Theresa Catholic Church</p>
            </div>
        </div>
        <div class="welcome">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>

</html>
