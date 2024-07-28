<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>75th Anniversary</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./css/photo.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="all_bg">
        <h1>75th Anniversary</h1>
    </div>
    <section>
        <div class="gallery_all">
            <?php
            $sql = "SELECT image_path FROM anniversary ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="gallery">';
                    echo '<a href="' . $row["image_path"] . '" data-fancybox="gallery">';
                    echo '<img src="' . $row["image_path"] . '" alt="Gallery Image">';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo "No images found.";
            }
            ?>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            $('[data-fancybox]').fancybox();
        });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>

<?php
$conn->close();
?>
