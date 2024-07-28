<?php
include 'db.php';

// Get total number of members
$sql_count = "SELECT COUNT(*) as total_members FROM members";
$result_count = $conn->query($sql_count);
$total_members = 0;

if ($result_count->num_rows > 0) {
    $row_count = $result_count->fetch_assoc();
    $total_members = $row_count['total_members'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Data Visualization</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="all">

        <div class="side">
            <?php include 'sidebar.php'; ?>
        </div>
        <div class="forms_all">
        <div class="forms">
            <h1>Member Data Visualization</h1>
        </div>
       <div class="box">
       <p>Total Members: 
        </p>
        <h1><?php echo $total_members; ?></h1>
       </div>
        <div class="chart_all">

            <div class="chart">
                <canvas id="genderChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="natalDayChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="nationalityChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="maritalStatusChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="educationChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="professionChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="confirmationChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="baptizedChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="societyChart"></canvas>
            </div>

        </div>
        <script>
            fetch('fetch_member_data.php')
                .then(response => response.json())
                .then(data => {
                    createChart('genderChart', 'Gender Distribution', data.gender);
                    createChart('natalDayChart', 'Natal Day Distribution', data.natal_day);
                    createChart('nationalityChart', 'Nationality Distribution', data.nationality);
                    createChart('maritalStatusChart', 'Marital Status Distribution', data.marital_status);
                    createChart('educationChart', 'Level of Education Distribution', data.level_of_education);
                    createChart('professionChart', 'Profession Distribution', data.profession);
                    createChart('confirmationChart', 'Confirmation Distribution', data.confirmation);
                    createChart('baptizedChart', 'Baptized Distribution', data.baptized);
                    createChart('societyChart', 'Society Distribution', data.society);
                });

            function createChart(elementId, title, data) {
                new Chart(document.getElementById(elementId), {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            label: title,
                            data: Object.values(data),
                            backgroundColor: [
                        'rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)', 'rgb(255, 159, 64)', 'rgb(255, 99, 71)', 'rgb(144, 238, 144)', 'rgb(173, 216, 230)',
                        'rgb(250, 128, 114)', 'rgb(255, 69, 0)', 'rgb(255, 20, 147)', 'rgb(138, 43, 226)', 'rgb(139, 69, 19)',
                        'rgb(47, 79, 79)', 'rgb(112, 128, 144)', 'rgb(119, 136, 153)', 'rgb(0, 255, 255)', 'rgb(0, 128, 128)',
                        'rgb(123, 104, 238)', 'rgb(72, 61, 139)', 'rgb(106, 90, 205)', 'rgb(240, 230, 140)', 'rgb(255, 140, 0)',
                        'rgb(255, 215, 0)', 'rgb(255, 248, 220)', 'rgb(240, 255, 255)', 'rgb(70, 130, 180)', 'rgb(176, 196, 222)',
                        'rgb(220, 20, 60)', 'rgb(255, 182, 193)', 'rgb(255, 160, 122)', 'rgb(250, 250, 210)', 'rgb(127, 255, 0)',
                        'rgb(173, 255, 47)', 'rgb(0, 250, 154)', 'rgb(144, 238, 144)', 'rgb(32, 178, 170)', 'rgb(0, 255, 127)',
                        'rgb(50, 205, 50)', 'rgb(255, 127, 80)', 'rgb(222, 184, 135)', 'rgb(255, 228, 196)', 'rgb(255, 218, 185)',
                        'rgb(218, 112, 214)', 'rgb(186, 85, 211)', 'rgb(148, 0, 211)', 'rgb(153, 50, 204)', 'rgb(147, 112, 219)'
                    ],
                            // borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        </script>
    </div>
</body>

</html>