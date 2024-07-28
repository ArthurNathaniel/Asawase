<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Message</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/all.css">
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="all_bg">
        <h1>Welcome Message</h1>
    </div>

    <section>
        <div class="welcome_all">
            <div class="welcome_text">
                <h1>WELCOME MESSAGE
                </h1>
                <p>
                I am deeply honored to welcome you to Asawase St. Theresa Catholic Church, a 
                place of faith, history, and community in the heart of Kumasi. It is with 
                immense pride that we celebrate our 75th anniversary 
                as one of the oldest and most cherished churches in the Kumasi Archdiocese.  
                </p>
                <p>
                For three-quarters of a century, this sacred place has been a beacon of faith, hope, and love, serving as a spiritual home for generations of believers. Our church's rich history is a testament to the enduring power of faith and the dedication of countless individuals who have contributed to its growth and vitality.  
                </p>
                <p>
                As we reflect on our past, we also look forward to the future with great anticipation. At Asawase St. Theresa Catholic Church, we are committed to preserving our traditions while embracing the challenges and opportunities of today's world. We are a vibrant and welcoming community that seeks to carry the torch of faith into the next 75 years and beyond.  
                </p>
                <p>
                Located in the heart of Asawase, Kumasi, our church is not just a physical structure; it is a gathering place for souls seeking solace, spiritual nourishment, and fellowship. We invite you to explore our historic church and join us in our worship services, community events, and ministries. 
                </p>
                <p>
                As we celebrate this significant milestone, we extend our heartfelt gratitude to all who have contributed to the life and legacy of our parish. We also extend a warm invitation to those who are new to our community to become a part of our story, as we continue to grow in faith and love.
                </p>
                <p>
                Please take the time to explore our website, where you can find more information about our history, our ministries, and our upcoming events. Should you have any questions or wish to connect with our parish, our doors and hearts are always open to you.   
                </p>
                <p>
                May the blessings of the Lord be with you and your families as we embark on this journey of faith together. May the next 75 years be filled with the same spirit of devotion, unity, and love that has defined our parish for generations.  
                </p>
                <p>
                    Rev Fr Gabriel Kofi Kyere <br>
                    Parish Priest
                </p>
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

    <?php include 'footer.php'; ?>
    <script src='./js/swiper.js'></script>
    <script src='./js/navbar.js'></script>
</body>
</html>