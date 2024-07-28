<?php
include 'db.php';

// Fetch data for each category
$gender_data = [];
$natal_day_data = [];
$nationality_data = [];
$marital_status_data = [];
$level_of_education_data = [];
$profession_data = [];
$confirmation_data = [];
$baptized_data = [];
$society_data = [];

$sql = "SELECT gender, natal_day, nationality, marital_status, level_of_education, profession, confirmation, baptized, society FROM members";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gender_data[] = $row['gender'];
        $natal_day_data[] = $row['natal_day'];
        $nationality_data[] = $row['nationality'];
        $marital_status_data[] = $row['marital_status'];
        $level_of_education_data[] = $row['level_of_education'];
        $profession_data[] = $row['profession'];
        $confirmation_data[] = $row['confirmation'];
        $baptized_data[] = $row['baptized'];
        $society_data = array_merge($society_data, explode(',', $row['society']));
    }
}

$conn->close();

echo json_encode([
    'gender' => array_count_values($gender_data),
    'natal_day' => array_count_values($natal_day_data),
    'nationality' => array_count_values($nationality_data),
    'marital_status' => array_count_values($marital_status_data),
    'level_of_education' => array_count_values($level_of_education_data),
    'profession' => array_count_values($profession_data),
    'confirmation' => array_count_values($confirmation_data),
    'baptized' => array_count_values($baptized_data),
    'society' => array_count_values($society_data),
]);
?>
