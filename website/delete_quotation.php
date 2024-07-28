<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quotation_id = $_POST['quotation_id'];

    $sql = "DELETE FROM quotations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $quotation_id);

    if ($stmt->execute()) {
        header("Location: view_quotations.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
