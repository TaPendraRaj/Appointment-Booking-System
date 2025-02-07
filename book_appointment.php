<?php
session_start();
include 'config.php';

// Ensure user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Validate session user ID
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    die("Error: User session ID is missing. Please log in again.");
}

$param_user_id = (int) $_SESSION["id"]; // Ensure it's an integer

// Check if user exists in the database
$user_check_sql = "SELECT id FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $user_check_sql)) {
    mysqli_stmt_bind_param($stmt, "i", $param_user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) == 0) {
        die("Error: The user does not exist. Please log in again.");
    }
    mysqli_stmt_close($stmt);
}

$date = $time = $service_id = $additional_info = "";
$date_err = $time_err = $service_err = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate service
    if (empty($_POST["service_id"])) {
        $service_err = "Please select a service.";
    } else {
        $service_id = trim($_POST["service_id"]);
    }

    // Validate date
    if (empty($_POST["date"])) {
        $date_err = "Please select a date.";
    } else {
        $date = trim($_POST["date"]);
    }

    // Validate time
    if (empty($_POST["time"])) {
        $time_err = "Please select a time.";
    } else {
        $time = trim($_POST["time"]);
    }

    // Additional info is optional
    $additional_info = trim($_POST["additional_info"]);

    // Check input errors before inserting in database
    if (empty($service_err) && empty($date_err) && empty($time_err)) {
        // Get the duration of the selected service
        $duration_sql = "SELECT duration FROM services WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $duration_sql)) {
            mysqli_stmt_bind_param($stmt, "i", $service_id);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                $service = mysqli_fetch_assoc($result);
                $duration = $service['duration'];
            } else {
                die("Oops! Something went wrong. Please try again later.");
            }
            mysqli_stmt_close($stmt);
        }

        // Prepare an insert statement
        $sql = "INSERT INTO appointments (user_id, service_id, date, time, duration, additional_info, status) VALUES (?, ?, ?, ?, ?, ?, 'confirmed')";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iissis", $param_user_id, $service_id, $date, $time, $duration, $additional_info);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Your appointment has been successfully booked!";
            } else {
                die("Oops! Something went wrong. Please try again later.");
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}

// Fetch available services
$sql = "SELECT id, name, description, duration FROM services";
$result = mysqli_query($conn, $sql);
$services = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="book_appointment.php" class="active">Book Appointment</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <h2>Book an Appointment</h2>

            <?php if (!empty($success_message)): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Service</label>
                    <select name="service_id" class="form-control <?php echo (!empty($service_err)) ? 'is-invalid' : ''; ?>">
                        <option value="">Select a service</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?php echo $service['id']; ?>" <?php echo ($service_id == $service['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($service['name']); ?> (<?php echo $service['duration']; ?> minutes)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="invalid-feedback"><?php echo $service_err; ?></span>
                </div>    
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                    <span class="invalid-feedback"><?php echo $date_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Time</label>
                    <input type="time" name="time" class="form-control <?php echo (!empty($time_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $time; ?>">
                    <span class="invalid-feedback"><?php echo $time_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Additional Information</label>
                    <textarea name="additional_info" class="form-control"><?php echo $additional_info; ?></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Book Appointment">
                </div>
            </form>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Appointment Booking System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
