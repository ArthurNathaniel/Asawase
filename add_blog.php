<?php
include 'db.php';

// Initialize $imagePaths array
$imagePaths = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $author = $_POST['author'];
    $content = $_POST['content'];

    // Handle multiple images
    $totalImages = count($_FILES['images']['name']);
    for ($i = 0; $i < $totalImages; $i++) {
        $imageName = $_FILES['images']['name'][$i];
        $imageTmpName = $_FILES['images']['tmp_name'][$i];
        $imagePath = 'uploads/' . $imageName;

        move_uploaded_file($imageTmpName, $imagePath);
        $imagePaths[] = $imagePath;
    }

    $imageJSON = json_encode($imagePaths);

    $sql = "INSERT INTO blogs (title, date, author, images, content) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $title, $date, $author, $imageJSON, $content);

    if ($stmt->execute()) {
        echo "New blog added successfully";
        // Clear uploaded images after successful submission
        $imagePaths = [];
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog</title>
    <style>
        .image-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Add New Blog</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required><br><br>
        <label for="images">Images:</label>
        <input type="file" id="images" name="images[]" multiple required accept="image/*"><br><br>
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="5" required></textarea><br><br>
        <input type="submit" value="Add Blog">
    </form>
    <h2>Uploaded Images:</h2>
    <div class="image-container">
        <?php
        if (!empty($imagePaths)) {
            foreach ($imagePaths as $imagePath) {
                echo '<img src="' . $imagePath . '" alt="Uploaded Image">';
            }
        }
        ?>
    </div>
</body>
</html>
