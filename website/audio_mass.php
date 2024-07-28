<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Audio Masses</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/audio_mass.css">
    <style>
        .progress-bar {
            width: 100%;
            height: 10px;
            background-color: #ddd;
            position: relative;
            margin-top: 10px;
            cursor: pointer;
        }

        .progress {
            height: 100%;
            background-color: #4caf50;
            width: 0%;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="all_bg">
        <h1>Audio Mass</h1>
    </div>
    <div class="all">
        <h1>View Audio Masses</h1>
        <div class="swiper mySwiper4">
            <div class="swiper-wrapper">
                <?php
                // Include the database connection file
                include 'db.php';

                // Retrieve the audio masses from the database
                $sql = "SELECT * FROM audio_mass ORDER BY id DESC";
                $result = $conn->query($sql);

                // Check if there are any audio masses
                if ($result->num_rows > 0) {
                    // Output each audio mass as a card
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="swiper-slide">';
                        echo '<div class="audio-card">';
                        echo '<div class="audio-card-image">';
                        echo '</div>';
                        echo '<audio id="audio-' . $row['id'] . '" src="' . $row['audio'] . '"></audio>';
                        echo '<div class="audio-controls">';
                        echo '';
                        echo '<span class="audio-timestamp" id="timestamp-' . $row['id'] . '">0:00 / 0:00</span>';
                        echo '</div>';
                        echo '<div class="progress-bar" id="progress-bar-' . $row['id'] . '" onclick="seekToTimestamp(event, ' . $row['id'] . ')"><div class="progress" id="progress-' . $row['id'] . '"></div></div>';
                        echo '<div class="controls">';
                        echo '<i class="fas fa-play" onclick="togglePlayPause(this, ' . $row['id'] . ')"></i>';
                        echo '<a href="' . $row['audio'] . '" download><i class="fas fa-download"></i></a>';
                        echo '</div>';
                        echo '<p>Title: ' . $row['title'] . '</p>';
                        echo '<p>Date: ' . $row['date'] . '</p>';
                        echo '<p>Author: ' . $row['author'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No audio masses available</p>';
                }

                // Close the database connection
                $conn->close();
                ?>
            </div>
            <br>
            <div class="arrow">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src='./js/swiper.js'></script>
    <script>
    var currentAudio = null;
    var currentTimestamp = null;
    var currentButton = null;

    function togglePlayPause(button, id) {
        var audio = document.getElementById('audio-' + id);
        if (audio.paused) {
            if (currentAudio && !audio.paused && currentAudio !== audio) {
                currentAudio.pause();
                currentButton.classList.remove('fa-pause');
                currentButton.classList.add('fa-play');
            }
            currentAudio = audio;
            currentTimestamp = document.getElementById('timestamp-' + id);
            currentButton = button;
            audio.play();
            button.classList.remove('fa-play');
            button.classList.add('fa-pause');
            updateTimestamp();
            audio.addEventListener('timeupdate', updateTimestamp);
        } else {
            audio.pause();
            button.classList.remove('fa-pause');
            button.classList.add('fa-play');
            audio.removeEventListener('timeupdate', updateTimestamp);
        }
    }

    function updateTimestamp() {
        if (currentAudio) {
            var currentTime = Math.floor(currentAudio.currentTime);
            var duration = Math.floor(currentAudio.duration);
            var currentMinutes = Math.floor(currentTime / 60);
            var currentSeconds = currentTime - currentMinutes * 60;
            var durationMinutes = Math.floor(duration / 60);
            var durationSeconds = duration - durationMinutes * 60;
            var timestamp = currentMinutes + ':' + (currentSeconds < 10 ? '0' : '') + currentSeconds +
                ' / ' + durationMinutes + ':' + (durationSeconds < 10 ? '0' : '') + durationSeconds;
            currentTimestamp.textContent = timestamp;

            // Calculate progress percentage
            var progress = (currentTime / duration) * 100;
            var progressBar = document.getElementById('progress-' + currentAudio.id.split('-')[1]);
            progressBar.style.width = progress + '%';
        }
    }

    // Function to seek to a specific timestamp
    function seekToTimestamp(event, id) {
        var progressBar = document.getElementById('progress-bar-' + id);
        var audio = document.getElementById('audio-' + id);
        var rect = progressBar.getBoundingClientRect();
        var mouseX = event.clientX - rect.left;
        var progress = (mouseX / rect.width);
        audio.currentTime = progress * audio.duration;
        updateTimestamp();
        if (audio.paused) {
            togglePlayPause(document.querySelector('.fa-play'), id);
        }
    }

    // Add event listener to the progress bar for seeking
    document.addEventListener('DOMContentLoaded', function () {
        var progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(function (progressBar) {
            progressBar.addEventListener('mousedown', function (event) {
                var id = this.id.split('-')[2];
                document.addEventListener('mousemove', function (event) {
                    seekToTimestamp(event, id);
                });
                document.addEventListener('mouseup', function () {
                    document.removeEventListener('mousemove', function () {});
                });
            });
        });
    });
</script>
</body>

</html>
