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

    // Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Username already exists";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user into database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        
        if ($stmt->execute()) {
            // Redirect to login page
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Error creating account. Please try again.";
        }
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
    <title>Signup</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/signup.css">
</head>

<body>
    <div class="forms_details">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="logo"></div>
            <div class="title">
                <h2>Olu's Kitchen - Signup</h2>
            </div>
            <div class="error_message">
                <p>
                    <span style="color: red;"><?php echo $error_message; ?></span>
                </p>
            </div>
            <div class="forms">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="forms">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="forms">
                <button type="submit" class="btns">SIGNUP</button>
            </div>
        </form>
    </div>
</body>

</html>
