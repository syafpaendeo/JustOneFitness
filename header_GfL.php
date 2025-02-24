<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <style>
    body {
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: black;
      height: 10vh;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      transition: height 0.3s ease, background-color 0.3s ease;
      overflow: hidden;
    }

    .header.expanded {
      height: 40vh;
      background-color: red; /* Add a color for visibility */
    }

    .header img {
      height: 90%;
      width: auto;
    }

    .gym-logo {
      margin-left: 2vh;
    }

    .text-logo {
      margin: 0 auto;
    }

    .image-button {
      margin-right: 2vh;
      cursor: pointer;
      border: none;
      background: none;
      padding: 0;
    }

    .image-button img {
      height: 10vh;
      width: auto;
    }
  </style>
  <title>Expandable Header</title>
</head>
<body>
  <div class="header">
    <img src="logo_GfL.png" alt="gym logo" class="gym-logo">
    <img src="GFL_text.png" alt="text logo" class="text-logo">
    <button onclick="window.location.href='https://youtu.be/_U-3iWTT8_k?si=-Ah_17alpvn-2Hyz';" class="image-button">
      <img src="imagebutton.png" alt="Button Image">
    </button>
  </div>
  <script>
    // JavaScript to handle click event
    document.querySelector('.image-button').addEventListener('click', function () {
      const header = document.querySelector('.header');
      header.classList.toggle('expanded');
    });
  </script>
</body>
</html>
