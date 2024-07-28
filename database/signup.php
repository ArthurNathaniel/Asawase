<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check for duplicate username or email
    $check_sql = "SELECT id FROM users WHERE username = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $username, $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>
            alert('Username or email already exists. Please try a different one.');
        </script>";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sss", $username, $email, $password);
            if ($stmt->execute()) {
                echo "<script>
                    alert('Signup successful!');
                    window.location.href = 'login.php';
                </script>";
            } else {
                echo "<script>
                    alert('Execute failed: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8') . "');
                </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
                alert('Prepare failed: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') . "');
            </script>";
        }
    }

    $check_stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./css/base.css">
    <style>
        .forms_all {
            padding-block: 50px;
        }
    </style>
</head>
<body>
    <div class="forms_all">
        <div class="logo"></div>
        <div class="forms">
            <h1>Signup</h1>
        </div>
        <form action="signup.php" method="post">
            <div class="forms">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
            </div>
            <div class="forms">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="forms">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="forms">
                <button type="submit" name="signup">Sign Up</button>
            </div>
        </form>
        <div class="forms">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
