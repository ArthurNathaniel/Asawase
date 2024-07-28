<?php
// session_start();

// // Check if the user is authenticated (logged in)
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// Retrieve the username from the session
$username = $_SESSION['username'];

// Check if the bookmark icon is clicked
if (isset($_GET['bookmark']) && !empty($_GET['bookmark'])) {
    $bookmark = urldecode($_GET['bookmark']);
    if (!isset($_SESSION['saved_cards'])) {
        $_SESSION['saved_cards'] = array();
    }
    array_push($_SESSION['saved_cards'], $bookmark);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <?php include 'cdn.php'; ?>
    <title>Home - The Catholic Podcast</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/home.css">
    <style>
        .progress-bar-container {
            width: 100%;
            height: 9px;
            background-color: #ddd;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-top: 15px;
        }

        .time {
            margin-top: 15px;
        }

        .progress-bar {
            height: 100%;
            background-color: #000;
            border-radius: 10px;
            position: absolute;
            width: 0;
            transition: width 0.3s;
        }

        .timestamp {
            margin-top: 5px;
        }

        .controls-inner {
            display: flex;
            align-items: center;
        }

        .controls-inner i {
            margin: 0 5px;
            cursor: pointer;
        }

        .ss img {
            border-radius: 30px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="whole">
        <div class="intro-grid">
            <div class="name">
                <h4>Welcome, <?php echo $username; ?>!</h4>
            </div>
            <div class="noty-icon">
                <div class="bell-box">
                    <h4><i class="fa-regular fa-bell"></i></h4>
                </div>
            </div>
        </div>
        <section id="dass">
            <div class="swiper mySwiper dash-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide ss">
                        <img src="./images/slide.jpg" alt="">
                    </div>

                </div>
            </div>
        </section>
        <div class="search-box">
            <input type="text" placeholder="Search...">
            <span><i class="fa-solid fa-magnifying-glass"></i></span>
        </div>
        <div class="audio-grid">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "asawase_website";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }



            $sql = "SELECT * FROM podcasts ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Start from the first row (recently added podcast)
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<div class="card-image"></div>';
                    echo '<div class="card-info">';
                    echo '<h4>' . $row["title"] . '</h4>';
                    echo '<p><b>Topic:</b> ' . $row["topic"] . '</p>';
                    echo '<p><b>Host:</b> ' . $row["host"] . '</p>';
                    echo '</div>';
                    echo '<div class="timestamp">';
                    echo '<div class="progress-bar-container" id="progress-bar-container-' . $count . '">';
                    echo '<div class="progress-bar" id="progress-bar-' . $count . '"></div>';
                    echo '</div>';
                    echo '<span class="time" id="timestamp-' . $count . '">0:00</span>';
                    echo '</div>';
                    echo '<audio id="audio-' . $count . '" src="' . $row["audio_url"] . '"></audio>';
                    echo '<div class="controls">';
                    echo '<div class="controls-inner">';
                    echo '<i class="fas fa-play" id="play-' . $count . '"></i>';
                    echo '<i class="fas fa-pause" id="pause-' . $count . '" style="display: none;"></i>';
                    echo '<a id="download-' . $count . '" href="' . $row["audio_url"] . '" download><i class="fas fa-download"></i></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $count++;
                }
            } else {
                echo "0 results found";
            }

            $conn->close();
            ?>
        </div>

        <?php
        $activePage = 'home';
        include 'footer.php'; ?>
        <script src="./javascript/dashboard.js"></script>

        <script>
    function initializeAudioPlayer(count) {
        const audio = document.getElementById('audio-' + count);
        const playBtn = document.getElementById('play-' + count);
        const pauseBtn = document.getElementById('pause-' + count);
        const progressBarContainer = document.getElementById('progress-bar-container-' + count);
        const progressBar = document.getElementById('progress-bar-' + count);
        const timestamp = document.getElementById('timestamp-' + count);

        playBtn.addEventListener('click', () => {
            audio.play();
            playBtn.style.display = 'none';
            pauseBtn.style.display = 'inline-block';
        });

        pauseBtn.addEventListener('click', () => {
            audio.pause();
            pauseBtn.style.display = 'none';
            playBtn.style.display = 'inline-block';
        });

        progressBarContainer.addEventListener('mousedown', (e) => {
            handleMouseDown(e, audio, progressBar, timestamp, progressBarContainer);
        });

        function handleMouseDown(e, audio, progressBar, timestamp, progressBarContainer) {
            const rect = progressBarContainer.getBoundingClientRect();
            const offsetX = e.clientX - rect.left;
            const percentage = Math.min(1, Math.max(0, offsetX / rect.width));

            // Update the progress bar
            progressBar.style.width = `${percentage * 100}%`;

            // Calculate the timestamp based on the percentage of the progress bar
            const currentTime = percentage * audio.duration;

            // Update the timestamp
            const minutes = Math.floor(currentTime / 60);
            const seconds = Math.floor(currentTime - minutes * 60);
            const formattedTime = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            timestamp.textContent = formattedTime;

            // Seek to the desired timestamp
            audio.currentTime = currentTime;

            // Add event listeners for mousemove and mouseup
            document.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', handleMouseUp);

            function handleMouseMove(event) {
                const newOffsetX = event.clientX - rect.left;
                const newPercentage = Math.min(1, Math.max(0, newOffsetX / rect.width));

                // Update the progress bar and timestamp
                progressBar.style.width = `${newPercentage * 100}%`;

                const newCurrentTime = newPercentage * audio.duration;
                const newMinutes = Math.floor(newCurrentTime / 60);
                const newSeconds = Math.floor(newCurrentTime - newMinutes * 60);
                const newFormattedTime = `${newMinutes}:${newSeconds < 10 ? '0' : ''}${newSeconds}`;
                timestamp.textContent = newFormattedTime;

                // Seek to the new timestamp
                audio.currentTime = newCurrentTime;
            }

            function handleMouseUp() {
                // Remove event listeners for mousemove and mouseup
                document.removeEventListener('mousemove', handleMouseMove);
                document.removeEventListener('mouseup', handleMouseUp);
            }
        }

        audio.addEventListener('timeupdate', () => {
            // Update the progress bar and timestamp during normal playback
            const progress = (audio.currentTime / audio.duration) * 100;
            progressBar.style.width = `${progress}%`;

            const minutes = Math.floor(audio.currentTime / 60);
            const seconds = Math.floor(audio.currentTime - minutes * 60);
            const formattedTime = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            timestamp.textContent = formattedTime;
        });
    }

    // Initialize audio players
    const numPlayers = <?php echo $result->num_rows; ?>;
    for (let i = 1; i <= numPlayers; i++) {
        initializeAudioPlayer(i);
    }
</script>


        <script src="./javascript/search.js"></script>
    </div>
</body>

</html>