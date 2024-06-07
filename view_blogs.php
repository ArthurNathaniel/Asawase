<?php
// Include the database connection file
include 'db.php';

// Check if the blog ID is provided for deletion
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete the blog post from the database
    $sql = "DELETE FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if($stmt->execute()) {
        // Redirect to the same page after deletion
        header("Location: view_blogs.php");
        exit();
    } else {
        echo "Error deleting blog post: " . $conn->error;
    }
}

// Retrieve the blog posts from the database
$sql = "SELECT * FROM blogs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Blogs</title>
    <style>
        .blog-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .blog-card img {
            max-width: 100%;
            height: 300px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .delete-btn {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>View Blogs</h1>
    <?php
    // Check if there are any blog posts
    if ($result->num_rows > 0) {
        // Output each blog post as a card
        while($row = $result->fetch_assoc()) {
            echo '<div class="blog-card">';
            echo '<h2>' . $row['title'] . '</h2>';
            echo '<p>Date: ' . $row['date'] . '</p>';
            echo '<p>Author: ' . $row['author'] . '</p>';
            // Decode JSON-encoded images
            $imagePaths = json_decode($row['images'], true);
            // Check if images exist and output the first image
            if (!empty($imagePaths)) {
                echo '<img src="' . $imagePaths[0] . '" alt="Blog Image">';
            }
            echo '<p>' . $row['content'] . '</p>';
            // Add delete option
            echo '<form action="" method="GET">';
            echo '<input type="hidden" name="delete_id" value="' . $row['id'] . '">';
            echo '<button type="submit" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this blog post?\')">Delete</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo '<p>No blog posts available</p>';
    }
    ?>
</body>
</html>
