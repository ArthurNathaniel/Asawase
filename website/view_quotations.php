<?php
include 'db.php';

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
    <title>View Quotations</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="dashboard">
        <section>
            <div class="quotation_all">
                <div class="quote_title">
                    <?php if ($quotation) : ?>
                        <h1><?php echo htmlspecialchars($quotation['title']); ?></h1>
                        <p><?php echo htmlspecialchars($quotation['verse']); ?></p>
                        <p><?php echo nl2br(htmlspecialchars($quotation['text'])); ?></p>
                        <form action="delete_quotation.php" method="post">
                            <input type="hidden" name="quotation_id" value="<?php echo htmlspecialchars($quotation['id']); ?>">
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
