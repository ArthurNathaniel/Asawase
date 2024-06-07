<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quotation_id = $_POST['quotation_id'];

    $sql = "DELETE FROM quotations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $quotation_id);

    if ($stmt->execute()) {
        $message = "Quotation deleted successfully";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

header("Location: quotation.php"); // Redirect back to the page after deletion
exit();
?>
