<?php
session_start();
include 'config.php';

$name = $email = $password = $confirm_password = "";
$name_err = $email_err = $password_err = $confirm_password_err = "";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your name.";
    } else{
        $name = trim($_POST["name"]);
    }
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST["email"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_password);
            
            $param_name = $name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Appointment Booking System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
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

        <main class="fade-in">
            <h1>Register</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="appointment-form">
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
                    <label>Password</label>
                    <input type="password" name="password">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div>
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div>
                    <input type="submit" value="Register">
                </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </main>

        <footer>
            <p>&copy; 2025 Appointment Booking System. All rights reserved.</p>
        </footer>
    </div>
    <script src="validation.js"></script>
</body>
</html>