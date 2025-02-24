<?php
include 'db_connection.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    $imagePath = '';

    // Image Upload
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "uploads/"; // Make sure this folder exists
        $imageName = basename($_FILES["image"]["name"]);
        $imagePath = $targetDir . time() . "_" . $imageName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO ratings (name, comment, rating, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $comment, $rating, $imagePath);

    if ($stmt->execute()) {
        echo "<script>alert('Rating submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error submitting rating.');</script>";
    }

    $stmt->close();
}

// Fetch all ratings
$result = $conn->query("SELECT * FROM ratings ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Just One Fitness</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="flaticon.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="icon" href="logo_GfL.png">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik:wght@300,400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Your homepage styles */
    body {
      margin: 0;
      padding: 0;
      background-color: #DD2370;
    }

    /* Navbar Styling */
.navbar-custom {
    background-color: black;
    transition: all 0.3s ease-in-out;
    padding: 10px 10px;
    height: 150px; /* Fixed height for the navbar */
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    display: flex;
    align-items: center;
}

.navbar-nav .nav-link:hover {
    color: #DD2370 !important;
}

.navbar-brand:hover {
    color: #DD2370 !important;
}

/* Shrinking Effect on Scroll */
.navbar-custom.shrink {
    height: 60px; /* Shrinks when scrolling */
    padding: 5px 10px;
}

/* Navbar Links */
.navbar-custom a {
    color: white !important;
}

/* Logo Styling */
.navbar-brand1 img {
    height: 100%; /* Makes the image fit the navbar height */
    max-height: 60px; /* Ensures the image is never too large */
    width: auto;
    object-fit: contain;
}


    .slideshow-container {
      position: relative;
      width: 100%;
      height: 100vh; /* Make slideshow take up full viewport height */
      margin-bottom: 50px;
      overflow: hidden; /* Hide images outside the container */
    }

    .slides {
      display: flex;
      transition: transform 1s ease; /* Smooth transition between slides */
    }

    .slide {
      width: 100%;
      flex-shrink: 0;
      height: 100%; /* Make each slide take up the full height of the container */
    }

    .slide img {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Ensures the image covers the area without distorting aspect ratio */
      display: block;
    }


    .motivation-text img {
      max-width: 100vh; /* Ensure image scales within its container */
      height: auto; /* Maintain aspect ratio */
      align-self: center;
    }

    .btn-dark:hover {
    color: #DD2370 !important;
    background-color: black !important;
    }

    .custom-btn {
    display: inline-block; /* Ensures it behaves as a button */
    margin-top: 10px; /* Adjust spacing from map */
    font-size: 1.5rem !important; /* Bigger text */
    padding: 15px 30px !important; /* Bigger button */
    border-radius: 10px !important; /* Rounded corners */
    background-color: black !important;
    color: white !important;
    border: none !important;
    transition: all 0.3s ease-in-out !important; /* Smooth animation */
}

.custom-btn:hover {
    color: #DD2370 !important; /* Text turns to DD2370 */
    background-color: #black !important; /* Slightly lighter black */
    transform: scale(1.1) !important; /* Expand button */
}

/* General Section Styling */
#ratings , #display-ratings{
    max-width: 500px;
    margin: 40px auto;
    padding: 25px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    text-align: center;
    animation: fadeIn 1s ease-in-out;
}

/* Form Group */
.form-group {
    margin-bottom: 15px;
    text-align: left;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

/* Input Fields */
input, textarea {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
}

/* Star Rating */
.stars {
    display: flex;
    justify-content: center;
    gap: 5px;
    font-size: 22px;
    direction: rtl; /* Right-to-left to reverse input order */
}

.stars input {
    display: none;
}

.stars label {
    color: #ccc;
    cursor: pointer;
    transition: 0.3s;
}

/* Highlight stars from the left when selected */
.stars input:checked ~ label,
.stars label:hover,
.stars label:hover ~ label {
    color: #ff9800;
    transform: scale(1.1);
}

/* Ensure hover also highlights previous stars */
.stars label:hover ~ label {
    color: #ff9800;
    transform: scale(1.1);
}

/* Submit Button */
.submit-button {
    background: linear-gradient(135deg, #ff416c, #ff4b2b);
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.submit-button:hover {
    transform: scale(1.05);
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
}

/* Smooth Fade-In Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}





    #footer {
        background: #000000;
        color: #fff;
        position: relative; /* Ensure the footer does not overlap other content */
        margin-top: 20px; /* Add some space above the footer */
        padding: 40px 0;
        flex-shrink: 0; /* Prevent shrinking */
        font-family: 'Roboto Condensed', sans-serif; /* Use Roboto Condensed */
    }

    #footer h4 {
        margin-bottom: 20px;
        font-size: 20px;
    }

    #footer p {
        margin-bottom: 10px;
    }

    #footer a {
        color: #DD2370;
        /* Adjust the color for links */
        text-decoration: none;
    }

    #footer a:hover {
        text-decoration: underline;
    }


  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand1" href="#">
            <img src="GfL_text.png" alt="GfL Logo">
        </a>
        <a class="navbar-brand" href="#">Home</a>

        <!-- Navbar Toggle Button -->
        <button class="navbar-toggler" id="mobile-menu" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Menu -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link active" href="#about-section">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="#transformations">Transformation</a></li>
                <li class="nav-item"><a class="nav-link active" href="#services">Trainings</a></li>
                <li class="nav-item"><a class="nav-link" href="#lokasi">Location</a></li>
                <li class="nav-item"><a class="nav-link" href="#ratings">Ratings</a></li>
                <li class="nav-item"><a class="nav-link" href="#footer">Our Contacts</a></li>
            </ul>
        </div>
    </div>
</nav>



<script>
window.addEventListener("scroll", function () {
    var navbar = document.querySelector(".navbar-custom");
    if (window.scrollY > 20) {
        navbar.classList.add("shrink");
    } else {
        navbar.classList.remove("shrink");
    }
});

// Mobile Navbar Toggle
document.addEventListener("DOMContentLoaded", function () {
    var menuButton = document.getElementById("mobile-menu");
    var navMenu = document.getElementById("navbarNavDropdown");

    menuButton.addEventListener("click", function () {
        navMenu.classList.toggle("active");
    });
});

</script>



<div class="image-container">
  <img src="pink_dumb.png" alt="Pink Dumbbells" class="background-image">
  <img src="motivation.png" alt="Your Body Your Mind" class="overlay-image">
</div>



      <section id="about-section" class="about-section">
    <div class="about-text">
        <h1 style="font-family: '3Dventure', sans-serif;">ABOUT US</h1>
        <p>
        Located in the heart of Bukit Indah, Ampang, Just One Fitness is more than just a gym—it’s a dedicated space for individuals who are serious about their health, fitness, and overall well-being. Whether you're a beginner or an experienced athlete, our modern facility provides the perfect environment to help you reach your goals. We believe that fitness is a lifestyle, and our mission is to support and inspire our members every step of the way.</p>
        <p>Our gym is fully equipped with state-of-the-art machines, free weights, and functional training areas to cater to a wide range of workout styles. Whether you prefer strength training, high-intensity interval workouts, or cardio exercises, we have everything you need for an effective session. In addition to our top-quality equipment, our certified trainers are available to provide professional guidance, helping you build strength, improve endurance, and achieve lasting results.
        </p>
        <p>At Just One Fitness, we offer more than just solo training. Our group classes provide an engaging and motivating way to stay active, whether through high-energy HIIT sessions, flexibility-focused yoga, or structured weight-training programs. We take pride in fostering a positive and supportive community where members encourage each other to push their limits and strive for continuous improvement.</p>
        <p>With flexible and affordable membership plans, we make it easy for you to prioritize your health and fitness. Whether you're looking to lose weight, build muscle, or simply stay active, we provide the right tools and support to help you succeed. Join us today and take the first step towards a stronger, healthier you! 💪</p>
    </div>
    <div class="about-image">
        <img src="gmbr_gym.jpg" alt="About Us Image">
    </div>
    <div class="blue-box"></div>
</section>

<!-- Before & After Transformation Section -->
<section id="transformations" class="transformation-section">
    <h2 class="section-title">Our Clients' Transformations</h2>
    <p class="section-description">See the amazing progress our clients have achieved!</p>

    <!-- Swiper Slider -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="gmbr1.png" alt="Transformation 1"></div>
            <div class="swiper-slide"><img src="gmbr2.png" alt="Transformation 2"></div>
            <div class="swiper-slide"><img src="gmbr3.png" alt="Transformation 3"></div>
            <div class="swiper-slide"><img src="gmbr4.png" alt="Transformation 4"></div>
            <div class="swiper-slide"><img src="gmbr5.png" alt="Transformation 5"></div>
        </div>
        <!-- Navigation Buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Pagination Dots -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- CSS for Styling -->
<style>
.transformation-section {
    text-align: center;
    padding: 60px 20px;
    background: #F78DA7;
    background: linear-gradient(to bottom, #ffb6c1, #ff69b4); /* Soft pink gradient */
    padding: 50px 0;
    text-align: center;
}
.section-title {
    font-size: 2rem;
    font-weight: bold;
    font-family: '3Dventure', sans-serif;
    margin-bottom: 10px;
}
.section-description {
    font-size: 1.2rem;
    color: #DD2370;
    margin-bottom: 30px;
}
.swiper {
    width: 80%;
    max-width: 800px;
    height: auto;
}
.swiper-slide img {
    width: 100%;
    border-radius: 10px;
}

/* Change Swiper navigation arrow color */
.swiper-button-next,
.swiper-button-prev {
    color: #DD2370 !important; /* Change to your preferred color */
}

/* Optional: Adjust arrow size */
.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 20px; /* Adjust as needed */
}
/* Change inactive dots */
.swiper-pagination-bullet {
    background-color: yellow !important; /* Change to your preferred color */
    opacity: 0.5;
}

/* Change active dot */
.swiper-pagination-bullet-active {
    background-color: #DD2370 !important; /* Change to your preferred color */
    opacity: 1;
}

</style>

<!-- Swiper.js CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
var swiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});
</script>




<section id="services" class="services">
  <h2 class="video-title">OUR TRAININGS</h2>
  <div class="video-wrapper">
      <div class="video-container">
          <video autoplay loop muted playsinline id="video">
              <source src="tabata.mov" type="video/mp4">
          </video>
          <div class="video-description">🔥 High-Intensity Tabata Workout! 🔥</div>
      </div>
      <div class="video-container">
        <video autoplay loop muted>
            <source src="strength.mov" type="video/mp4">
        </video>
        <div class="video-description">🔥 High-Intensity Strength Training! 🔥</div>
    </div>
    <div class="video-container">
        <video autoplay loop muted>
            <source src="boxing_cardio.mov" type="video/mp4">
        </video>
        <div class="video-description">🔥 High-Intensity Boxing Training! 🔥</div>
    </div>
  </div>
</section>
<script>
const videos = document.querySelectorAll(".video-container video");
const body = document.querySelector("body");

videos.forEach(video => {
    video.addEventListener("mouseenter", () => {
        videos.forEach(v => {
            if (v !== video) {
                v.closest(".video-container").classList.add("blur-effect");
            }
        });
    });

    video.addEventListener("mouseleave", () => {
        videos.forEach(v => {
            v.closest(".video-container").classList.remove("blur-effect");
        });
    });
});

</script>

<section id="lokasi" style="background-color: #F78DA7; margin-top: 50px;">
    <br id="location">
    <div class="pink-box"></div>
    <br>
    <br>
    <h2 id="azmir" style="text-align: center; font-size: 2rem; font-weight: bold; font-family: '3Dventure', sans-serif;">Location</h2>
    <div class="container mt-4">
        <!-- Google Map Embed -->
        <div class="d-flex justify-content-center mb-5">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.7810402779996!2d101.7724539747832!3d3.1523650968230137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc371f887675cf%3A0x41fe035389b26512!2sJust%20One%20Fitness!5e0!3m2!1sen!2smy!4v1740187099428!5m2!1sen!2smy" width="1000" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <!-- Button -->
        <div class="text-center">
          <a href="https://maps.app.goo.gl/wZ9DxqcrvLaTUmqQA" class="custom-btn" target="_blank">Go to Google Map</a>
        </div>
    </div>
    <br>
    <br>
    <br>
</section>

<section id="ratings">
    <h2>Rate Our Gym</h2>
    <form action="submit_rating.php" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea name="comment" required></textarea>
        </div>

        <div class="form-group">
            <label>Service Quality:</label>
            <div class="stars">
                <input type="radio" name="service_quality" value="5" id="service5"><label for="service5">&#9733;</label>
                <input type="radio" name="service_quality" value="4" id="service4"><label for="service4">&#9733;</label>
                <input type="radio" name="service_quality" value="3" id="service3"><label for="service3">&#9733;</label>
                <input type="radio" name="service_quality" value="2" id="service2"><label for="service2">&#9733;</label>
                <input type="radio" name="service_quality" value="1" id="service1"><label for="service1">&#9733;</label>
            </div>
        </div>

        <div class="form-group">
            <label>Environment Quality:</label>
            <div class="stars">
                <input type="radio" name="environment_quality" value="5" id="env5"><label for="env5">&#9733;</label>
                <input type="radio" name="environment_quality" value="4" id="env4"><label for="env4">&#9733;</label>
                <input type="radio" name="environment_quality" value="3" id="env3"><label for="env3">&#9733;</label>
                <input type="radio" name="environment_quality" value="2" id="env2"><label for="env2">&#9733;</label>
                <input type="radio" name="environment_quality" value="1" id="env1"><label for="env1">&#9733;</label>
            </div>
        </div>

        <div class="form-group">
            <label>Overall Quality:</label>
            <div class="stars">
                <input type="radio" name="overall_quality" value="5" id="overall5"><label for="overall5">&#9733;</label>
                <input type="radio" name="overall_quality" value="4" id="overall4"><label for="overall4">&#9733;</label>
                <input type="radio" name="overall_quality" value="3" id="overall3"><label for="overall3">&#9733;</label>
                <input type="radio" name="overall_quality" value="2" id="overall2"><label for="overall2">&#9733;</label>
                <input type="radio" name="overall_quality" value="1" id="overall1"><label for="overall1">&#9733;</label>
            </div>
        </div>

        <div class="form-group">
            <label for="image">Upload Progress Photo (optional):</label>
            <input type="file" name="image">
        </div>

        <button type="submit" name="submit" class="submit-button">Submit Rating</button>
    </form>
</section>



<section id="display-ratings">
    <h2>User Ratings</h2>

    <?php
    $sql = "SELECT * FROM ratings ORDER BY created_at DESC LIMIT 2";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='rating-box'>";
        echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong></p>";
        echo "<p>" . htmlspecialchars($row['comment']) . "</p>";
        echo "<p>Service: " . str_repeat("⭐", $row['service_quality']) . "</p>";
        echo "<p>Environment: " . str_repeat("⭐", $row['environment_quality']) . "</p>";
        echo "<p>Overall: " . str_repeat("⭐", $row['overall_quality']) . "</p>";
        if ($row['image_path']) {
            echo "<img src='" . $row['image_path'] . "' alt='Progress Image' width='100'>";
        }
        echo "</div>";
    }
    ?>
</section>




<div class="footer">
    <footer id="footer" class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4 style="color: #D3DD22;">Contact Us</h4>
                    <p>
                        Just One Fitness Only For Ladies<br>
                        30-2, Medan Bukit Indah2, Taman Bukit Indah, 68000 Ampang, Selangor<br>
                        Phone: (+60) 12-251 1993

                    </p>
                </div>
                <div class="col-md-4">
                    <h4 style="color: #D3DD22;">About Us</h4>
                    <p>Your attitude is everything for success. Don't show up late, Don't try to slide out early.
                      Don't cheat your rep counts and definitely, Don't hold back.
                    </p>
                </div>
                <div class="col-md-4">
                    <h4 style="color: #D3DD22;">Follow Us</h4>
                    <div>
                        <a href="https://www.facebook.com/JustOneFitnessforLadies" target="_blank">Facebook</a>
                        <br>
                        <a href="https://www.instagram.com/justonefitness?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">Instagram</a>
                        <br>
                        <a href="https://www.tiktok.com/@jaswantjas262?is_from_webapp=1&sender_device=pc" target="_blank">Tiktok</a>
                    </div>
                </div>
            </div>
            <hr>

        </div>
    </footer>
</div>
</body>
</html>
