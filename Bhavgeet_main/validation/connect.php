<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'spotify-api';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

    if(!$conn ) {
        die('Could not connect: ' . mysqli_error());
    }
?>