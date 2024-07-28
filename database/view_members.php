<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Members</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/member.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#membersTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</head>
<body>
<div class="all">
        
<div class="side">
<?php include 'sidebar.php'; ?>
</div>
<div class="member">
    <h1>Members List</h1>
<div class="forms">
<input type="text" id="searchInput" placeholder="Search for members...">
</div>
    <table id="membersTable">
        <thead>
            <tr>
                <th>Profile Image</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Telephone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, name, gender, telephone, profile_picture FROM members";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td><img src='" . $row['profile_picture'] . "' alt='Profile Picture' width='50px'></td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['gender'] . "</td>
                        <td>" . $row['telephone'] . "</td>
                        <td><a href='member_details.php?id=" . $row['id'] . "'>View Details</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No members found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</div>
</body>
</html>
