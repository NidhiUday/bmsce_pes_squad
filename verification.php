<?php
//connecting to the database
include 'partials/_dbconnect.php';
//sets the timezone
date_default_timezone_set("Asia/Kolkata");
//default message printed as soon as the mail is shooted
$msg = "please check your mail to verify email!!";

if (!empty($_GET['vkey']) && isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];
    $sql = mysqli_query($conn, "SELECT * FROM credentials WHERE vkey='$vkey'");
    $num = mysqli_fetch_array($sql);

    if ($num > 0) //Not NULL
    {
        $st = 0;
        $result = mysqli_query($conn, "SELECT sno from credentials WHERE vkey='$vkey' and status='$st'");
        $result4 = mysqli_fetch_array($result);
        if ($result4 > 0) {
            $st = 1;
            $result1 = mysqli_query($conn, "UPDATE credentials SET status='$st' WHERE vkey='$vkey'");
            $msg = "Your account has been activated";
        } else {
            $msg = "Your account is already activated, please Login.";
        }
    } else {
        $msg = "wrong activation link";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mail Verification</title>
    <link rel="stylesheet" href="emailVerificationStyle.css">
</head>

<body>
    <div class="mail">
        <img class="mail2" src="images/email.png" />
        <h1><?php
            echo $msg;
            ?><br></h1>
        <div class="linkss">
            <a href="login.php">login</a>
        </div>
    </div>
</body>

</html>