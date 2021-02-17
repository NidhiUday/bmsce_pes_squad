<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "credentials";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die("error" . mysqli_connect_error());
}
