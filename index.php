<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Appointment Booking System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php" <?php echo ($_SERVER['PHP_SELF'] == "/index.php" ? 'class="active"' : ''); ?>>Home</a></li>
            <li><a href="about.php" <?php echo ($_SERVER['PHP_SELF'] == "/about.php" ? 'class="active"' : ''); ?>>About</a></li>
            <li><a href="contact.php" <?php echo ($_SERVER['PHP_SELF'] == "/contact.php" ? 'class="active"' : ''); ?>>Contact</a></li>
            <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <li><a href="book_appointment.php" <?php echo ($_SERVER['PHP_SELF'] == "/book_appointment.php" ? 'class="active"' : ''); ?>>Book Appointment</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" <?php echo ($_SERVER['PHP_SELF'] == "/login.php" ? 'class="active"' : ''); ?>>Login</a></li>
                <li><a href="register.php" <?php echo ($_SERVER['PHP_SELF'] == "/register.php" ? 'class="active"' : ''); ?>>Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

    <main>
        <h1>Welcome to Our Appointment Booking System</h1>
        <p>We offer a variety of services to meet your needs. Book an appointment today!</p>
    <h2>How it works:</h2>
  <ul>
    <li><strong>Choose your service</strong> from a wide range of options.</li>
    <li><strong>Select a date and time</strong> that suits you.</li>
    <li><strong>Confirm your booking</strong> and relax while we prepare for your appointment.</li>
  </ul>
  <p>Our goal is to provide you with a seamless experience so you can focus on what matters most.</p>
  <p>Start your journey by booking your first appointment today!</p>
</body>
    </main>

    <footer>
        <p>&copy; 2025 Appointment Booking System. All rights reserved.</p>
    </footer>
</body>
</html>




