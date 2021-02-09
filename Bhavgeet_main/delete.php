<?php
    $host="localhost";
    $username="root";
    $password="";
    $dbname="spotify-api";

    $conn=new mysqli($host,$username,$password,$dbname);
    if ($conn->connect_errno) {
        echo "Failed to connect to MySQL: ".$mysqli->connect_error;
        exit();
    }

    $deleterecords = "TRUNCATE TABLE musicinfo";

    mysqli_query( $conn, $deleterecords );
    header("Location:./index.html")
?>

