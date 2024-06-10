<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Audio Mass</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/sidebar.css">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="dashboard">
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
          
                echo "<script>alert('New audio mass added successfully');</script>";

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
    <div class="forms">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>
    </div>
        <div class="forms">
        <label for="audio">Audio:</label>
        <input type="file" id="audio" name="audio" required accept="audio/*">
        </div>
       <div class="forms">
       <label for="date">Date:</label>
       <input type="date" id="date" name="date" required>
       </div>
      <div class="forms">
      <label for="author">Author:</label>
      <input type="text" id="author" name="author" required>
      </div>
        <!-- <input type="submit" value="Add Audio Mass"> -->
        <div class="forms">
            <button type="submit">Add Audio Mass</button>
        </div>
    </form>
    </div>
</body>
</html>
