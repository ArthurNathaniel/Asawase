<?php
include 'db.php';

// Initialize $imagePaths array
$imagePaths = [];

// Check if there are already uploaded images for editing
if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];

    $sql = "SELECT images FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $imagePaths = json_decode($row['images'], true);
    }
    $stmt->close();
}

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
     
        echo "<script>alert('New Event or Announcement added successfully');</script>";

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="dashboard">
        <div class="forms">
            <h1>Add New Events / Announcement</h1>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="forms">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="forms">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="forms">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div class="forms">
                <label for="images">Images:</label>
                <input type="file" id="images" name="images[]" multiple required accept="image/*">
            </div>
            <div class="forms">
                <label for="content">Content:</label><br>
                <textarea id="content" name="content" rows="5" required></textarea>
            </div>
            <!-- <input type="submit" value="Add Blog"> -->
            <div class="forms">
                <button type="submit">Add Blog</button>
            </div>
        </form>

    </div>
</body>

</html>