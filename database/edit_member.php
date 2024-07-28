<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $member_id = $_POST['id'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $natal_day = $_POST['natal_day'];
    $telephone = $_POST['telephone'];
    $nationality = $_POST['nationality'];
    $marital_status = $_POST['marital_status'];
    $level_of_education = $_POST['level_of_education'];
    $profession = $_POST['profession'];
    $confirmation = $_POST['confirmation'];
    $baptized = $_POST['baptized'];
    $society = implode(',', $_POST['society']);
    $nlb_number = $_POST['nlb_number'];

    // Check if a new profile picture is uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['profile_picture']['name'];
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_path = 'uploads/' . basename($file_name);
        if (move_uploaded_file($file_tmp, $file_path)) {
            $profile_picture = $file_path;
        }
    } else {
        // Use the current profile picture if no new one is uploaded
        $profile_picture = $_POST['current_profile_picture'];
    }

    $sql = "UPDATE members SET 
            name = ?, 
            dob = ?, 
            gender = ?, 
            natal_day = ?, 
            telephone = ?, 
            nationality = ?, 
            marital_status = ?, 
            level_of_education = ?, 
            profession = ?, 
            confirmation = ?, 
            baptized = ?, 
            society = ?, 
            nlb_number = ?,
            profile_picture = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssi", 
        $name, 
        $dob, 
        $gender, 
        $natal_day, 
        $telephone, 
        $nationality, 
        $marital_status, 
        $level_of_education, 
        $profession, 
        $confirmation, 
        $baptized, 
        $society, 
        $nlb_number,
        $profile_picture,
        $member_id
    );

    if ($stmt->execute()) {
        echo "<script>
            alert('Member updated successfully!');
            window.location.href = 'view_members.php';
        </script>";
    } else {
        echo "<script>
            alert('Error: " . $stmt->error . "');
            window.location.href = 'view_members.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
} else {
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
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
</head>
<body>
<div class="all">
    <div class="side">
        <?php include 'sidebar.php'; ?>
    </div>
    <div class="forms_all">
        <div class="forms">
            <h1>Edit Member</h1>
        </div>
        <form action="edit_member.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
            <div class="forms">
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo $member['name']; ?>" required>
            </div>
            <div class="forms">
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" value="<?php echo $member['dob']; ?>" required>
            </div>
            <div class="forms">
                <label for="gender">Gender:</label>
                <select name="gender" required>
                    <option value="" hidden>Select Gender</option>
                    <option value="Male" <?php echo $member['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo $member['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="forms">
                <label for="natal_day">Natal Day:</label>
                <select name="natal_day" required>
                    <option value="" hidden>Select Natal Day</option>
                    <option value="Monday" <?php echo $member['natal_day'] == 'Monday' ? 'selected' : ''; ?>>Monday</option>
                    <option value="Tuesday" <?php echo $member['natal_day'] == 'Tuesday' ? 'selected' : ''; ?>>Tuesday</option>
                    <option value="Wednesday" <?php echo $member['natal_day'] == 'Wednesday' ? 'selected' : ''; ?>>Wednesday</option>
                    <option value="Thursday" <?php echo $member['natal_day'] == 'Thursday' ? 'selected' : ''; ?>>Thursday</option>
                    <option value="Friday" <?php echo $member['natal_day'] == 'Friday' ? 'selected' : ''; ?>>Friday</option>
                    <option value="Saturday" <?php echo $member['natal_day'] == 'Saturday' ? 'selected' : ''; ?>>Saturday</option>
                    <option value="Sunday" <?php echo $member['natal_day'] == 'Sunday' ? 'selected' : ''; ?>>Sunday</option>
                </select>
            </div>
            <div class="forms">
                <label for="telephone">Telephone:</label>
                <input type="text" name="telephone" value="<?php echo $member['telephone']; ?>" required>
            </div>
            <div class="forms">
                <label for="nationality">Nationality:</label>
                <select name="nationality" required>
                    <option value="" hidden>Select Nationality</option>
                    <option value="Ghana" <?php echo $member['nationality'] == 'Ghana' ? 'selected' : ''; ?>>Ghana</option>
                </select>
            </div>
            <div class="forms">
                <label for="marital_status">Marital Status:</label>
                <select name="marital_status" required>
                    <option value="" hidden>Select Marital Status</option>
                    <option value="Single" <?php echo $member['marital_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                    <option value="Married" <?php echo $member['marital_status'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                    <option value="Religious" <?php echo $member['marital_status'] == 'Religious' ? 'selected' : ''; ?>>Religious</option>
                </select>
            </div>
            <div class="forms">
                <label for="level_of_education">Level of Education:</label>
                <select name="level_of_education" required>
                    <option value="" hidden>Select Level of Education</option>
                    <option value="Primary" <?php echo $member['level_of_education'] == 'Primary' ? 'selected' : ''; ?>>Primary</option>
                    <option value="Junior High" <?php echo $member['level_of_education'] == 'Junior High' ? 'selected' : ''; ?>>Junior High</option>
                    <option value="Senior High" <?php echo $member['level_of_education'] == 'Senior High' ? 'selected' : ''; ?>>Senior High</option>
                    <option value="Tertiary" <?php echo $member['level_of_education'] == 'Tertiary' ? 'selected' : ''; ?>>Tertiary</option>
                </select>
            </div>
            <div class="forms">
                <label for="profession">Profession:</label>
                <select name="profession" required>
                    <option value="" hidden>Select Profession</option>
                    <option value="Worker" <?php echo $member['profession'] == 'Worker' ? 'selected' : ''; ?>>Worker</option>
                    <option value="Student" <?php echo $member['profession'] == 'Student' ? 'selected' : ''; ?>>Student</option>
                </select>
            </div>
            <div class="forms">
                <label for="confirmation">Confirmation:</label>
                <select name="confirmation" required>
                    <option value="" hidden>Select Confirmation</option>
                    <option value="Yes" <?php echo $member['confirmation'] == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                    <option value="No" <?php echo $member['confirmation'] == 'No' ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
            <div class="forms">
                <label for="baptized">Baptized:</label>
                <select name="baptized" required>
                    <option value="" hidden>Select Baptized</option>
                    <option value="Yes" <?php echo $member['baptized'] == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                    <option value="No" <?php echo $member['baptized'] == 'No' ? 'selected' : ''; ?>>No</option>
                </select>
            </div>
            <div class="forms">
                <label for="society">Society:</label>
                <select id="society" name="society[]" multiple required>
                    <option value="Sacred Heart of Confraternity" <?php echo in_array('Sacred Heart of Confraternity', explode(',', $member['society'])) ? 'selected' : ''; ?>>Sacred Heart of Confraternity</option>
                    <option value="Youth Choir" <?php echo in_array('Youth Choir', explode(',', $member['society'])) ? 'selected' : ''; ?>>Youth Choir</option>
                    <option value="Legion of Mary" <?php echo in_array('Legion of Mary', explode(',', $member['society'])) ? 'selected' : ''; ?>>Legion of Mary</option>
                    <option value="Charismatic" <?php echo in_array('Charismatic', explode(',', $member['society'])) ? 'selected' : ''; ?>>Charismatic</option>
                    <option value="St Theresa Society" <?php echo in_array('St Theresa Society', explode(',', $member['society'])) ? 'selected' : ''; ?>>St Theresa Society</option>
                    <option value="COSRA" <?php echo in_array('COSRA', explode(',', $member['society'])) ? 'selected' : ''; ?>>COSRA</option>
                    <option value="Children of Mary" <?php echo in_array('Children of Mary', explode(',', $member['society'])) ? 'selected' : ''; ?>>Children of Mary</option>
                    <option value="Knight and Ladies of Marshall" <?php echo in_array('Knight and Ladies of Marshall', explode(',', $member['society'])) ? 'selected' : ''; ?>>Knight and Ladies of Marshall</option>
                    <option value="Young Men's" <?php echo in_array('Young Men\'s', explode(',', $member['society'])) ? 'selected' : ''; ?>>Young Men's</option>
                    <option value="Mary Mother of Mothers" <?php echo in_array('Mary Mother of Mothers', explode(',', $member['society'])) ? 'selected' : ''; ?>>Mary Mother of Mothers</option>
                    <option value="Theresa Mma Kuo" <?php echo in_array('Theresa Mma Kuo', explode(',', $member['society'])) ? 'selected' : ''; ?>>Theresa Mma Kuo</option>
                    <option value="Men's" <?php echo in_array('Men\'s', explode(',', $member['society'])) ? 'selected' : ''; ?>>Men's</option>
                    <option value="Senior Choir" <?php echo in_array('Senior Choir', explode(',', $member['society'])) ? 'selected' : ''; ?>>Senior Choir</option>
                    <option value="Lay Reader's" <?php echo in_array('Lay Reader\'s', explode(',', $member['society'])) ? 'selected' : ''; ?>>Lay Reader's</option>
                    <option value="Ushers" <?php echo in_array('Ushers', explode(',', $member['society'])) ? 'selected' : ''; ?>>Ushers</option>
                    <option value="St Anthony Guild" <?php echo in_array('St Anthony Guild', explode(',', $member['society'])) ? 'selected' : ''; ?>>St Anthony Guild</option>
                    <option value="Northern Union" <?php echo in_array('Northern Union', explode(',', $member['society'])) ? 'selected' : ''; ?>>Northern Union</option>
                    <option value="CYO" <?php echo in_array('CYO', explode(',', $member['society'])) ? 'selected' : ''; ?>>CYO</option>
                    <option value="St Theresa Guild" <?php echo in_array('St Theresa Guild', explode(',', $member['society'])) ? 'selected' : ''; ?>>St Theresa Guild</option>
                    <option value="KLBS" <?php echo in_array('KLBS', explode(',', $member['society'])) ? 'selected' : ''; ?>>KLBS</option>
                    <option value="Knight and Ladies of St John" <?php echo in_array('Knight and Ladies of St John', explode(',', $member['society'])) ? 'selected' : ''; ?>>Knight and Ladies of St John</option>
                </select>
            </div>
            <div class="forms">
                <label for="nlb_number">NLB Number:</label>
                <input type="text" name="nlb_number" value="<?php echo $member['nlb_number']; ?>" >
            </div>
            <div class="forms">
    <label for="profile_picture">Profile Picture:</label>
    <input type="file" name="profile_picture" accept="image/*">
    <?php if (!empty($member['profile_picture'])): ?>
        <img src="<?php echo $member['profile_picture']; ?>" alt="Profile Picture" style="width: 100px; height: auto;">
        <input type="hidden" name="current_profile_picture" value="<?php echo $member['profile_picture']; ?>">
    <?php endif; ?>
</div>


            <div class="forms">
                <input type="submit" name="submit" value="Update Member">
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Choices('#society', { removeItemButton: true });
    });
</script>
</body>
</html>
