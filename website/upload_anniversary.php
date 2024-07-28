<?php
include 'db.php';

$uploadSuccessMessage = "";
$uploadErrorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "anniversary/";
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
            $stmt = $conn->prepare("INSERT INTO anniversary (image_path) VALUES (?)");
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
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/photo.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
   <div class="dashboard">
   <section>
        <div class="upload_form">
            <?php if ($uploadSuccessMessage): ?>
                <p style="color: green;"><?php echo $uploadSuccessMessage; ?></p>
            <?php endif; ?>
            <?php if ($uploadErrorMessage): ?>
                <p style="color: red;"><?php echo $uploadErrorMessage; ?></p>
            <?php endif; ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="forms">
                    <h1>Upload 75th Anniversary Images</h1>
                    <p style="color: red; ">The images should be less 3MB</p>
                </div>
             <div class="forms">
             <label for="file">Choose image to upload:</label>
             <input type="file" name="file" id="file" accept="image/*" required>
             </div>
               <div class="forms">
               <button type="submit">Upload Image</button>
               </div>
            </form>
        </div>
    </section>
   </div>
  
</body>
</html>

<?php
$conn->close();
?>
