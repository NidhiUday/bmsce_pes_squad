<?php
//sets the timezone
date_default_timezone_set("Asia/Kolkata");

$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //connecting to the database
    include 'partials/_dbconnect.php';

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    //check whether this username Exits 
    $existsql = "SELECT * FROM credentials WHERE email='$email'";
    $result = mysqli_query($conn, $existsql);
    $numExistRow = mysqli_num_rows($result);

    if ($numExistRow > 0) {
        $showError = "Email id already registered. Please try to log-in.";
    } else {
        if ($password == $cpassword) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $vkey = password_hash(($email . time()), PASSWORD_DEFAULT);
            $sql = "INSERT INTO `credentials` (`username`, `email`, `password`, `vkey`, `dt`) VALUES ('$username', '$email', '$hash', '$vkey', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $to = $email;
                $msg = "Thankyou for Registering to BMSCE PES Squad.";
                $subject = "Email Verification (BMSCE PES : Squad)";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                $headers .= 'From:B.M.S. College Of Engineering | BMSCE PES
                <bp56727r@gmail.com' . "\r\n";
                $ms .= "<html><body><div><div> Dear $username,</div></br></br>";
                $ms .= "<div style='padding-top:8px;'>Please click on the following link to verify and activate your account</div>
                <div style='padding-top:10px;'><a href='http://localhost/project/verification.php?vkey=$vkey'>Click Here!</a></div>
                <div style='padding-top:4px;'>Powered By <a href:'http://www.google.com'>google.com</a></div>
                </body></html>";
                mail($to, $subject, $ms, $headers);
                //ADD A PAGE
                echo "<script>alert('Registration successful, please verify in the registered email-id');</script>";
                header("location:verification.php");
                echo "<script>window.location='verification.php';</script>";
                $showAlert = true;
            } else {
                //echo "<script>alert('Data not inserted');</script>";
                $showError = "Account could not be created. Please try again!";
            }
        } else {
            $showError = "Password donot match ";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- remove after creating your own nav bar -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>


<body>
    <?php require 'partials/_nav.php'; ?>

    <?php
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Youre account is created and you can login.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        // header("location: login.php");
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
        <h2>Sign-in</h2>
        <form action="index.php" method="POST">
            <div class="inputBox">
                <input type="text" maxlength="11" id="username" name="username" required>
                <label for="username"><i class="fa fa-user"></i> Username</label>
            </div>
            <div class="inputBox">
                <input type="email" maxlength="23" id="email" name="email" required>
                <label for="email"><i class="fa fa-user"></i> E-mail</label>
            </div>
            <div class="inputBox">
                <input type="password" maxlength="23" class="password" name="password" required>
                <label for="password"><i class="fa fa-lock"></i> Password</label>
            </div>
            <div class="inputBox">
                <input type="password" class="cpassword" name="cpassword" required>
                <label for="cpassword"><i class="fa fa-lock"></i> Confirm Password</label>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">sign Up</button>
                <label style="color:white;"><br>Do you already have an account?
                    <a href="login.php" style="text-decoration: none; color: #03a9f4;">Log-In</a>
                </label>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>

</html>