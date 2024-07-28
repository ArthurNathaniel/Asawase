<?php
include 'db.php';

if (isset($_GET['id'])) {
    $member_id = $_GET['id'];

    $sql = "DELETE FROM members WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $member_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Member deleted successfully.');
            window.location.href = 'view_members.php';
        </script>";
    } else {
        echo "<script>
            alert('Error deleting member: " . $stmt->error . "');
            window.location.href = 'view_members.php';
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('No member ID provided.');
        window.location.href = 'view_members.php';
    </script>";
}

$conn->close();
?>
