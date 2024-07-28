<?php
include 'db.php';

// Handle file upload
$profile_picture = '';
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['profile_picture']['name'];
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $file_path = 'uploads/' . basename($file_name);
    if (move_uploaded_file($file_tmp, $file_path)) {
        $profile_picture = $file_path;
    }
}

// Check for duplicates
$sql_check = "SELECT * FROM members WHERE name = ? AND dob = ? AND telephone = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("sss", $_POST['name'], $_POST['dob'], $_POST['telephone']);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "<script>
        alert('A member with the same name, date of birth, and telephone already exists.');
        window.location.href = 'register.php';
    </script>";
} else {
    // Prepare SQL statement for insertion
    $sql = "INSERT INTO members (name, dob, gender, natal_day, telephone, email, nationality, marital_status, level_of_education, profession, confirmation, baptized, society, nlb_number, profile_picture, username, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $password_hashed = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $society = implode(',', $_POST['society']);
    
    $stmt->bind_param("sssssssssssssssss",
        $_POST['name'],
        $_POST['dob'],
        $_POST['gender'],
        $_POST['natal_day'],
        $_POST['telephone'],
        $_POST['email'],
        $_POST['nationality'],
        $_POST['marital_status'],
        $_POST['level_of_education'],
        $_POST['profession'],
        $_POST['confirmation'],
        $_POST['baptized'],
        $society,
        $_POST['nlb_number'],
        $profile_picture,
        $_POST['username'],
        $password_hashed
    );
    
    if ($stmt->execute()) {
        echo "<script>
            alert('Registration successful!');
            window.location.href = 'register.php';
        </script>";
    } else {
        echo "<script>
            alert('Error: " . $stmt->error . "');
            window.location.href = 'register.php';
        </script>";
    }
    
    $stmt->close();
}

$stmt_check->close();
$conn->close();
?>
