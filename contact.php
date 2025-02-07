<?php
session_start();
include 'config.php';

$name = $email = $message = "";
$name_err = $email_err = $message_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your name.";
    } else{
        $name = trim($_POST["name"]);
    }
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_err = "Invalid email format.";
        }
    }
    
    // Validate message
    if(empty(trim($_POST["message"]))){
        $message_err = "Please enter your message.";
    } else{
        $message = trim($_POST["message"]);
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($message_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_message);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_message = $message;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to thank you page
                header("location: contact_thank_you.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Appointment Booking System</title>
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
        <h1>Contact Us</h1>
        <p>If you have any questions or concerns, please feel free to reach out to us using the form below.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>    
            <div>
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div>
                <label>Message</label>
                <textarea name="message" rows="5"><?php echo $message; ?></textarea>
                <span class="invalid-feedback"><?php echo $message_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Send Message">
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 Appointment Booking System. All rights reserved.</p>
    </footer>

    <script src="validation.js"></script>
</body>
</html>