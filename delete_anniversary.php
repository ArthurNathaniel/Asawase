<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $imageId = $_POST['image_id'];
    $sql = "SELECT image_path FROM anniversary WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    $sql = "DELETE FROM anniversary WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Images</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/all.css">
    <style>
        .gallery_all {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            padding: 0 5%;
        }
        .gallery {
            width: 95%;
            height: 300px;
            margin-top: 50px;
            position: relative;
        }
        .gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .delete-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this image?");
        }
    </script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="all_bg">
        <h1>Delete Images</h1>
    </div>
    <section>
        <div class="gallery_all">
            <?php
            $sql = "SELECT id, image_path FROM anniversary";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="gallery">';
                    echo '<img src="' . $row["image_path"] . '" alt="Gallery Image">';
                    echo '<form method="post" action="" class="delete-form" onsubmit="return confirmDelete();">';
                    echo '<input type="hidden" name="image_id" value="' . $row["id"] . '">';
                    echo '<button type="submit" name="delete" class="delete-button">Delete</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo "No images found.";
            }
            ?>
        </div>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>

<?php
$conn->close();
?>
