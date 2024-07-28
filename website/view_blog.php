<!-- view_blog.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Blog</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
    <style>
        .image-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            margin-top: 50px;
        }
    </style>
</head>
<body>
  
    <?php
    include 'db.php';

    if(isset($_GET['id'])) {
        $blog_id = $_GET['id'];

        $sql = "SELECT * FROM blogs WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $blog_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $title = $row['title'];
            $date = $row['date'];
            $author = $row['author'];
            $images = json_decode($row['images'], true);
            $content = $row['content'];
            echo "<div class='all'>";
            echo "<h1>$title</h1>";
          
            echo "<p>$content</p>";
            echo "<div class='image-container'>";
            foreach ($images as $image) {
                echo "<img src='$image' alt='Image'>";
            }
            echo "</div>";
            echo "<div class='flex_all'>";
            echo "<p>Date: $date</p>";
            echo "<p>Author: $author</p>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "Blog not found";
        }

        $stmt->close();
    } else {
        echo "Blog ID not specified";
    }
    ?>
</body>
</html>
