<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Appointment Booking System</title>
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
        <h1>About Us</h1>
        <section>
            <h2>Our Mission</h2>
            <p>At our Appointment Booking System, we strive to provide a seamless and efficient way for our clients to schedule their appointments. Our goal is to save time for both our customers and our staff, ensuring a smooth and pleasant experience for everyone involved.</p>
        </section>
        <section>
            <h2>Our Services</h2>
            <ul>
                <li><strong>Doctor Consultation:</strong> Book a session with a medical professional for personalized health advice.</li><b><br>
                <img src="2.avif" alt="" width="400" style="margin-left: 200px;"><br>
                <li><strong>Haircut:</strong> Get a trendy haircut from experienced stylists to refresh your look.</li><b><bR>
                <img src="1.jpg" alt="" width="400" style="margin-left: 200px;"><br>
                <li><strong>Legal Consultation:</strong> Schedule a consultation with a legal expert for advice on legal matters.</li><b><br>
                <img src="3.jpeg" alt="" width="400" style="margin-left: 200px;"><br>
                <li><strong>Fitness Training:</strong> Personalized workout sessions with certified trainers to achieve your fitness goals.</li><br><b>
                <img src="4.jpg" alt="" width="400" style="margin-left: 200px;"><br>
                <li><strong>Car Repair:</strong> Professional vehicle repair services to keep your car in top condition.</li><b><br>
                <img src="5.png" alt="" width="400" style="margin-left: 200px;"><br>
            </ul>

        </section>
        <section>
            <h2>Our Team</h2>
            <p>Our dedicated team of professionals is committed to providing you with the best possible service. With years of experience in the industry, we ensure that your needs are met with the highest standards of quality and care.</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Appointment Booking System. All rights reserved.</p>
    </footer>
</body>
</html>