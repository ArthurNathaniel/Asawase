<?php
include 'db.php';

if (isset($_GET['id'])) {
    $member_id = $_GET['id'];

    $sql = "SELECT * FROM members WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $member = $result->fetch_assoc();
    } else {
        echo "<script>
            alert('Member not found.');
            window.location.href = 'view_members.php';
        </script>";
        exit;
    }

    $stmt->close();
} else {
    echo "<script>
        alert('No member ID provided.');
        window.location.href = 'view_members.php';
    </script>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Details</title>
    <link rel="stylesheet" href="./css/base.css">
</head>
<body>

<div class="container">
    <h1>Member Details</h1>
    <div class="member-details">
        <img src="<?php echo $member['profile_picture']; ?>" alt="Profile Picture" width="150">
        <p><strong>Name:</strong> <?php echo $member['name']; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $member['dob']; ?></p>
        <p><strong>Gender:</strong> <?php echo $member['gender']; ?></p>
        <p><strong>Natal Day:</strong> <?php echo $member['natal_day']; ?></p>
        <p><strong>Telephone:</strong> <?php echo $member['telephone']; ?></p>
        <p><strong>Nationality:</strong> <?php echo $member['nationality']; ?></p>
        <p><strong>Marital Status:</strong> <?php echo $member['marital_status']; ?></p>
        <p><strong>Level of Education:</strong> <?php echo $member['level_of_education']; ?></p>
        <p><strong>Profession:</strong> <?php echo $member['profession']; ?></p>
        <p><strong>Confirmation:</strong> <?php echo $member['confirmation']; ?></p>
        <p><strong>Baptized:</strong> <?php echo $member['baptized']; ?></p>
        <p><strong>Society:</strong> <?php echo $member['society']; ?></p>
        <p><strong>NLB Number:</strong> <?php echo $member['nlb_number']; ?></p>
        
        <a href="edit_member.php?id=<?php echo $member['id']; ?>" class="button">Edit</a>
        <a href="delete_member.php?id=<?php echo $member['id']; ?>" class="button" onclick="return confirm('Are you sure you want to delete this member?');">Delete</a>
    </div>
</div>

</body>
</html>
