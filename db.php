<?php
$conn = mysqli_connect("localhost", "root", "", "cosmetics_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>