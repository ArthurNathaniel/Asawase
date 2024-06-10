<?php
session_start();

// Include database connection
include 'db.php';

// Define variable for error message
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL select statement
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($user_id, $username, $hashed_password);

    // Fetch the result
    if ($stmt->fetch()) {
        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Store user id and username in session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            // Redirect to dashboard.php
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Invalid username or password";
        }
    } else {
        $error_message = "Invalid username or password";
    }

    // Close statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <div class="login">
    <div class="forms_details">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="logo forms"></div>
            <div class="forms">
                <h2>Welcome back - Login</h2>
                <p>Asawase St Theresa's Catholic Church</p>
            </div>
            <div class="error_message">
                <p>
                    <span style="color: red;"><?php echo $error_message; ?></span>
                </p>
            </div>
            <div class="forms">
                <label for="username">Username:</label>
                <input type="text" placeholder="Enter your username" id="username" name="username" required>
            </div>
            <div class="forms">
                <label for="password">Password:</label>
                <input type="password" placeholder="Enter your password" id="password" name="password" required>
            </div>
            <div class="forms">
                <button type="submit" class="btns">LOGIN</button>
            </div>
            <!-- <div class="forms">
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            </div> -->
        </form>
    </div>
    </div>
</body>

</html>
