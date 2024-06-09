<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $audioId = $_POST['audio_id'];
    $sql = "SELECT audio FROM audio_mass WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $audioId);
    $stmt->execute();
    $stmt->bind_result($audioPath);
    $stmt->fetch();
    $stmt->close();

    if (file_exists($audioPath)) {
        unlink($audioPath);
    }

    $sql = "DELETE FROM audio_mass WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $audioId);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Audio Mass</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/photo.css">
</head>
<body>
    <h1>Delete Audio Mass</h1>
    <section>
        <div class="gallery_all">
            <?php
            $sql = "SELECT id, title, audio FROM audio_mass ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="gallery">';
                    echo '<p>Title: ' . $row["title"] . '</p>';
                    echo '<audio controls><source src="' . $row["audio"] . '" type="audio/mpeg"></audio>';
                    echo '<form method="post" action="" class="delete-form" onsubmit="return confirmDelete();">';
                    echo '<input type="hidden" name="audio_id" value="' . $row["id"] . '">';
                    echo '<button type="submit" name="delete" class="delete-button">Delete</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo "No audio mass found.";
            }
            ?>
        </div>
    </section>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this audio?");
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
