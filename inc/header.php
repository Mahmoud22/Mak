<?php include('login_system/dashboard.php'); ?>

<!-- Meta Tags for Responsive Design -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- jQuery and Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f8f8;
    }

    .navbar {
        background-color: #0C007A;
        color: white;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap; /* Allows items to wrap on smaller screens */
        position: relative;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
    }

    .navbar nav {
        display: flex;
        flex-wrap: wrap; /* Makes navigation items wrap on smaller screens */
        justify-content: center;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        transition: background-color 0.3s;
    }

    .navbar a:hover {
        background-color: #F8F8F8;
    }

    .container {
        margin-top: 20px;
        padding: 15px;
    }

    /* Responsive Design for Mobile Screens */
    @media (max-width: 768px) {
        .navbar {
            flex-direction: column; /* Stack items vertically */
            align-items: center;
        }

        .navbar a {
            padding: 10px;
            width: 100%; /* Make links full-width */
            text-align: center;
        }

        .logo {
            margin-bottom: 10px; /* Add space between logo and links */
        }
    }
</style>

<div class="navbar">
    <div class="logo">Logo</div>
    <nav>
        <a href="form.php">الرئيسية</a>
        <a href="ground.php">الوحدات السكنية</a>
        <a href="services.php">الخدمات والأسعار</a>
        <a href="services2.php">العملاء والمشاريع</a>
    </nav>
</div>
