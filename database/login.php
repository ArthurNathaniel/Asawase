<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $id;
                echo "<script>
                    alert('Login successful!');
                    window.location.href = 'dashboard.php';
                </script>";
            } else {
                echo "<script>
                    alert('Invalid username or password.');
                </script>";
            }
        } else {
            echo "<script>
                alert('Invalid username or password.');
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('Prepare failed: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') . "');
        </script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/base.css">
    <style>
        .forms_all{
            padding-block: 50px;
        }
    </style>
</head>
<body>
    <div class="forms_all">
        <div class="logo"></div>
     <div class="forms">
     <h1>Login</h1>
     </div>
        <form action="login.php" method="post">
            <div class="forms">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="forms">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="forms">
                <button type="submit" name="login">Login</button>
            </div>
        </form>
        <div class="forms">
            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        </div>
    </div>
</body>
</html>
