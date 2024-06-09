<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include 'cdn.php';?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/audio_mass.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="all_bg">
        <h1>Blog</h1>
    </div>
    <section>
    <div class="blog_all">
        <div class="blog_title">
            <h1>Blogs/ News</h1>
        </div>
        <div class="blog">
            <div class="swiper mySwiper3">
                <div class="swiper-wrapper">
                    <?php
                    include 'db.php';
                    $sql = "SELECT id, title, date, author, images FROM blogs ORDER BY id DESC"; // Select image column
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $images = json_decode($row['images'], true); // Decode JSON images array
                            $image = !empty($images) ? $images[0] : ''; // Get the first image
                            echo '<div class="swiper-slide">';
                            echo '<a href="view_blog.php?id=' . $row['id'] . '">';
                            echo '<div class="blog_card">';
                            echo '<div class="blog_img"><img src="' . $image . '" alt=""></div>'; // Use $image instead of $row['image']
                            echo '<div class="blog_info">';
                            echo '<p>' . $row['title'] . '</p>';
                            echo '<p><i class="fa-solid fa-calendar-days"></i> ' . $row['date'] . '</p>';
                            echo '<p><i class="fa-solid fa-user"></i> ' . $row['author'] . '</p>';
                            echo '</div></div></a></div>';
                        }
                    } else {
                        echo '<p>No blogs available</p>';
                    }
                    ?>
                </div>
                <br><br>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
    <script src='./js/swiper.js'></script>
    <script src='./js/navbar.js'></script>

</body>

</html>