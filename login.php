<?php
//sets the timezone
date_default_timezone_set("Asia/Kolkata");

$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //connecting to the database
    include 'partials/_dbconnect.php';
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "select * from credentials where email='$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_array($result)) {
            if ($row['status'] == 1) {
                if (password_verify($password, $row['password'])) {
                    $login = true;
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $email;
                    header("location:welcome.php");
                } else {
                    $showError = "Invalid credentials";
                }
            } else {
                $showError = "Please verify email ID using the mail we sent you";
            }
        }
    } else {
        $showError = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- remove after creating your own nav bar -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>


<body>
    <?php require 'partials/_nav.php'; ?>
    <?php
    if ($login) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>  ' . $showError . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <video id="videoBG" poster="images/poster.png" autoplay muted loop>
        <source src="images/loginvideo.mp4" type="video/mp4">
    </video>

    <div class="box">
        <h2>Log-in</h2>
        <form action="login.php" method="POST">
            <div class="inputBox">
                <input type="email" id="email" name="email" required>
                <label for="email"><i class="fa fa-user"></i> E-mail</label>
            </div>
            <div class="inputBox">
                <input type="password" class="password" name="password" required>
                <label for="password"><i class="fa fa-lock"></i> Password</label>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Log in</button><br>
                <label style="color:white;"><br>Don't have an account?
                    <a href="index.php" style="text-decoration: none; color: #03a9f4;">Sign-In</a>
                </label>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>

</html>