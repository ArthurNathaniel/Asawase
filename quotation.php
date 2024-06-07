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
</head>

<body>
    <h1>Add New Quotation</h1>
    <?php if (!empty($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="verse">Verse:</label>
        <input type="text" id="verse" name="verse" required><br><br>
        <label for="text">Text:</label>
        <textarea id="text" name="text" required></textarea><br><br>
        <input type="submit" value="Add Quotation">
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
</body>

</html>
