<?php
session_start();
include 'config.php';

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

$email = $password = "";
$email_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($email_err) && empty($password_err)){
        $sql = "SELECT id, name, email, password FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $name, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;                            
                            
                            header("location: index.php");
                        } else{
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else{
                    $login_err = "Invalid email or password.";
                }
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
    <title>Login - Appointment Booking System</title>
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
                    <li><a href="login.php" <?php echo ($_SERVER['PHP_SELF'] == "/login.php" ? 'class="active"' : ''); ?>>Login</a></li>
                    <li><a href="register.php" <?php echo ($_SERVER['PHP_SELF'] == "/register.php" ? 'class="active"' : ''); ?>>Register</a></li>
                    <li><a href="book_appointment.php" <?php echo ($_SERVER['PHP_SELF'] == "/book_appointment.php" ? 'class="active"' : ''); ?>>Book Appointment</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main class="fade-in">
            <h1>Login</h1>
            <p>Please fill in your credentials to login.</p>

            <?php 
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="appointment-form">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>    
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div>
                    <input type="submit" value="Login">
                </div>
                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            </form>
        </main>

        <footer>
            <p>&copy; 2025 Appointment Booking System. All rights reserved.</p>
        </footer>
    </div>
    <script src="validation.js"></script>
</body>
</html>