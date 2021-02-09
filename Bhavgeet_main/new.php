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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Tyles</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
 </head>
<body >
<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>
<a href="#" class="btn" style=" color:white;display: flex;justify-content: center;align-items: center;width:150px;margin:50px auto;">Home Page</a>
    <div class="row row-cols-1 row-cols-md-3 g-4 " style="margin:15px;">
        <?php

            $sql="SELECT * FROM `musicinfo`";
            $result=$conn->query($sql);

            while($row=$result->fetch_assoc()){
                
echo '<div class="col">';


echo '<div class="forcard" data-tilt>';
echo '<img src="'.$row['img'].'" alt="user">';
echo '<h1 style=" font-size:25px; text-align: center;">'.$row['Trackname'].'</h1>';
echo '<h3 style=" font-size:20px;">'.$row['Artistname'].'</h3>';
echo '<h3>'.$row['reldate'].'</h3>';
echo '<a href="'.$row['src'].'" target="_blank" class="round-button"><i class="fa fa-play fa-2x"></i></a>';
echo '</div>';
echo '</div>';



            }
        ?>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- tilt js -->
    <script src="./js/vanilla-tilt.min.js"></script>
</body>
</html>