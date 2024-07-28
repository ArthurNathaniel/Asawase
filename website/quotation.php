<?php
include 'db.php';

// Handle form submission
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

// Fetch the latest quotation
$sql = "SELECT id, title, verse, text FROM quotations ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($sql);
$quotation = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotations</title>
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
        <form action="" method="post">
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
                <textarea id="text"  placeholder="Enter the memory verse" name="text" required></textarea>
            </div>
            <div class="forms">
                <!-- <input type="submit" value="Add Quotation"> -->
                <button type="submit" >Add Quotation</button>
            </div>
        </form>

        <section>
            <div class="quotation_all">
                <div class="quote_title">
                    <?php if ($quotation) : ?>
                        <h1><?php echo $quotation['title']; ?></h1>
                        <p><?php echo $quotation['verse']; ?></p>
                        <p><?php echo nl2br($quotation['text']); ?></p>
                        <form action="delete_quotation.php" method="post">
                            <input type="hidden" name="quotation_id" value="<?php echo $quotation['id']; ?>">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this quotation?')">Delete</button>
                        </form>
                    <?php else : ?>
                        <h1>No Quotations Available</h1>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</body>

</html>