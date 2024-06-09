<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Welcome to the official website of Asawase St Theresa's Catholic Church. Join us for Mass, participate in community events, and grow spiritually with our parish in Asawase. We are committed to serving our community with faith, hope, and love.">
    <meta name="keywords" content="Asawase, St Theresa's Catholic Church, Catholic Church, Mass schedule, community events, spiritual growth, parish activities, Asawase religious services, faith community, worship services, church events, church service times">
    <meta name="author" content="Asawase St Theresa's Catholic Church">
    <meta property="og:title" content="Asawase St Theresa's Catholic Church - Home">
    <meta property="og:description" content="Join us at Asawase St Theresa's Catholic Church for Mass, community events, and spiritual growth. Serving the Asawase community with faith and love.">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Asawase St Theresa's Catholic Church - Home">
    <meta name="twitter:description" content="Welcome to Asawase St Theresa's Catholic Church. Join us for Mass and community events in Asawase.">
    <title>Asawase St Theresa's Catholic Church - Home</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <section>
        <div class="hero_all">
            <div class="swiper mySwiper">
                <div class="hero_text">
                    <h1>Welcome to Asawase St Theresa's Catholic Church</h1>
                    <p>
                        Roman deɛ ɛnoaa ne Asawase, Wopɛ ade pa bra Asawase
                    </p>
                </div>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="./images/hero_three.jpg" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="./images/hero_two.jpg" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="./images/hero_one.jpg" alt="">
                    </div>

                </div>
              
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <section>
        <div class="mass_all">
            <div class="mass_text">
                <h1>Church Service Schedule</h1>
                <p>
                    At Asawase St. Theresa Catholic Church, we hold two Sunday Masses at 6:30 AM and 9:00 AM. The first Sunday of each month includes a Benediction. Every Thursday, we gather for morning prayer at 6:00 AM. We also have a Youth Mass on the last Monday of each month. From Monday to Saturday, daily Mass is held at 6:00 AM. We warmly welcome everyone to join us and deepen their faith.
                </p>
            </div>
            <div class="mass_swiper">
                <div class="swiper mySwiper2">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="mass_card">
                                <div class="mass_img"></div>
                                <div class="mass_info">
                                    <h3>First Mass</h3>
                                    <p>6:30am - 8:30am</p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="mass_card">
                                <div class="mass_img"></div>
                                <div class="mass_info">
                                    <h3>Second Mass</h3>
                                    <p>8:30am - 10:00am</p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="mass_card">
                                <div class="mass_img"></div>
                                <div class="mass_info">
                                    <h3>Weekdays Mass</h3>
                                    <p>6:00am - 7:00am</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="mass_card">
                                <div class="mass_img"></div>
                                <div class="mass_info">
                                    <h3>Thurday Morning Prayer</h3>
                                    <p>9:30am - 12:00am</p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="mass_card">
                                <div class="mass_img"></div>
                                <div class="mass_info">
                                    <h3>1st Sunday of Every Month</h3>
                                    <p>6:00pmm - 7:00pm</p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="mass_card">
                                <div class="mass_img"></div>
                                <div class="mass_info">
                                    <h3>1st Monday of Every Month</h3>
                                    <p>6:30am - 8:30am</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="quotation_all">
            <div class="quote_title">
                <?php
                include 'db.php';
                $sql = "SELECT title, verse, text FROM quotations ORDER BY created_at DESC LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<h1>" . $row['title'] . "</h1>";
                    echo "<p>" . $row['verse'] . "</p>";
                    echo "<p>" . nl2br($row['text']) . "</p>";
                } else {
                    echo "<h1>No Quotations Available</h1>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>
    <section>
    <div class="blog_all">
        <div class="blog_title">
            <h1>Events & Announcement</h1>
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