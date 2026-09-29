<?php

session_start();


if (!isset($_SESSION["user_id"])) {

    header("Location: index.php");

    exit();

}


$fullname = $_SESSION["fullname"];

$username = $_SESSION["username"];

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Home | Future System</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>


<body class="home-page">

<div class="grid"></div>


<nav class="navbar">

    <div class="nav-logo">
        ✦ FUTURE
    </div>


    <div class="nav-links">

    <a href="home.php" class="active">
        HOME
    </a>

    <a href="users.php">
        USERS
    </a>

    <a href="#">
        ABOUT
    </a>

    <a href="#">
        SERVICES
    </a>

</div>


    <a
        href="logout.php"
        class="logout-btn"
    >
        LOGOUT
    </a>

</nav>


<main class="home-content">


    <section class="hero">

        <div class="hero-text">

            <p class="small-title">
                WELCOME TO THE FUTURE
            </p>


            <h1>

                WELCOME,
                <span>
                    <?= htmlspecialchars($fullname) ?>
                </span>

            </h1>


            <p class="hero-description">

                You are successfully logged in.

                Your username is:

                <strong>
                    <?= htmlspecialchars($username) ?>
                </strong>

            </p>


            <div class="hero-buttons">

                <button
                    class="primary-btn"
                    onclick="alert('Welcome to the Future System!')"
                >
                    GET STARTED
                </button>

            </div>

        </div>


        <div class="hero-visual">

            <div class="orbit orbit-one"></div>

            <div class="orbit orbit-two"></div>

            <div class="core">

                <div class="core-symbol">
                    ✦
                </div>

            </div>

        </div>

    </section>


    <section class="features">

        <div class="feature-card">

            <div class="feature-icon">
                ⚡
            </div>

            <h3>
                FAST
            </h3>

            <p>
                Experience a fast and responsive
                digital environment.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">
                ◈
            </div>

            <h3>
                SECURE
            </h3>

            <p>
                Your account information
                is protected.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">
                ◉
            </div>

            <h3>
                SMART
            </h3>

            <p>
                Intelligent tools designed
                for modern users.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">
                ✧
            </div>

            <h3>
                FUTURISTIC
            </h3>

            <p>
                A modern interface built
                for tomorrow.
            </p>

        </div>

    </section>


    <section class="welcome-panel">

        <div>

            <p class="panel-label">
                SYSTEM STATUS
            </p>

            <h2>
                SYSTEM ONLINE
            </h2>

            <p>

                Welcome back,

                <span>
                    <?= htmlspecialchars($fullname) ?>
                </span>

            </p>

        </div>


        <div class="status-indicator">

            <span></span>

            ONLINE

        </div>

    </section>


</main>


<footer>

    <p>
        © 2026 FUTURE SYSTEM.
        ALL RIGHTS RESERVED.
    </p>

</footer>

</body>

</html>