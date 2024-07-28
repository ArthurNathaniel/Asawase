<?php
include 'db.php';

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $verse = $_POST['verse'];
    $text = $_POST['text'];

    $sql = "INSERT INTO quotations (title, verse, text) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $verse, $text);

    if ($stmt->execute()) {
        $message = "New quotation added successfully";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quotation</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="dashboard">
        <h1>Add New Quotation</h1>
        <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="add_quotation.php" method="post">
            <div class="forms">
                <label for="title">Title:</label>
                <input type="text" placeholder="Enter your title" id="title" name="title" required>
            </div>
            <div class="forms">
                <label for="verse">Verse:</label>
                <input type="text" placeholder="Enter your verse" id="verse" name="verse" required>
            </div>
            <div class="forms">
                <label for="text">Memory Verse:</label>
                <textarea id="text" placeholder="Enter the memory verse" name="text" required></textarea>
            </div>
            <div class="forms">
                <button type="submit">Add Quotation</button>
            </div>
        </form>
    </div>
</body>

</html>
