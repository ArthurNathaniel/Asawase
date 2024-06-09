<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Audio Mass</title>
</head>
<body>
   
    <h1>Add Audio Mass</h1>
    <?php
    // Include the database connection file
    include 'db.php';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission
        $title = $_POST['title'];
        $date = $_POST['date'];
        $author = $_POST['author'];

        // Handle audio file upload
        $audioName = $_FILES['audio']['name'];
        $audioTmpName = $_FILES['audio']['tmp_name'];
        $audioPath = 'audio/' . $audioName;

        if (move_uploaded_file($audioTmpName, $audioPath)) {
            // File uploaded successfully, insert data into database
            $sql = "INSERT INTO audio_mass (title, audio, date, author) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $title, $audioPath, $date, $author);

            if ($stmt->execute()) {
                echo "New audio mass added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $stmt->close();
        } else {
            echo "Error uploading audio file.";
        }
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="audio">Audio:</label>
        <input type="file" id="audio" name="audio" required accept="audio/*"><br><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required><br><br>
        <input type="submit" value="Add Audio Mass">
    </form>
</body>
</html>
