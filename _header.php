<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'PlanPal'; ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">

    <script src="assets/js//script.js"></script>
</head>

<body style="height: 100vh">
    <?php if (isset($_SESSION['user_id']) && $_SERVER['PHP_SELF'] === '/index.php') : ?>
        <div class="success_indicator">
            <div class="container">
                <p>Logged in.</p>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    <?php endif; ?>
    <header>
        <div class="container" id="top_nav">
            <a href="index.php">
                <div class="logo">
                    <img src="assets/images/logo.png" alt="PlanPal Logo">
                </div>
            </a>
            <nav>
                <ul>
                    <li><a href="events.php">Events</a></li>
                    <li><a href="#contact">Contact</a></li>

                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <?php if ($_SERVER['PHP_SELF'] !== '/upload.php') : ?>
                            <li><a class="btn-primary" href="upload.php">Add Event</a></li>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php if ($_SERVER['PHP_SELF'] !== '/login.php' && $_SERVER['PHP_SELF'] !== '/signup.php') : ?>
                            <li><a class="btn-primary-outlined" href="login.php">Login</a></li>
                            <li><a class="btn-primary" href="signup.php">Sign Up</a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>