<?php
include 'db.php';

$uploadSuccessMessage = "";
$uploadErrorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "gallery/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadErrorMessage = "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadErrorMessage = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 3000000) {
        $uploadErrorMessage = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadErrorMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $uploadErrorMessage = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Save file path to database
            $stmt = $conn->prepare("INSERT INTO gallery (image_path) VALUES (?)");
            $stmt->bind_param("s", $target_file);
            $stmt->execute();
            $stmt->close();
            $uploadSuccessMessage = "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
        } else {
            $uploadErrorMessage = "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/all.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="all_bg">
        <h1>Upload Image</h1>
    </div>
    <section>
        <div class="upload_form">
            <?php if ($uploadSuccessMessage): ?>
                <p style="color: green;"><?php echo $uploadSuccessMessage; ?></p>
            <?php endif; ?>
            <?php if ($uploadErrorMessage): ?>
                <p style="color: red;"><?php echo $uploadErrorMessage; ?></p>
            <?php endif; ?>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="file">Choose image to upload:</label>
                <input type="file" name="file" id="file" accept="image/*" required>
                <button type="submit">Upload Image</button>
            </form>
        </div>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>

<?php
$conn->close();
?>
