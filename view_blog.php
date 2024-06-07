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
        $images = json_decode($row['images'], true); // Decode JSON array
        $content = $row['content'];

        // Display blog content
        echo "<h1>$title</h1>";
        echo "<p>Date: $date</p>";
        echo "<p>Author: $author</p>";
        echo "<div class='image-container'>";
        foreach ($images as $image) {
            echo "<img src='$image' alt='Blog Image'>";
        }
        echo "</div>";
        echo "<p>$content</p>";
    } else {
        echo "Blog not found";
    }

    $stmt->close();
} else {
    echo "Blog ID not specified";
}
?>
