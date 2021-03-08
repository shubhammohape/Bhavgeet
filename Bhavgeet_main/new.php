<?php
set_time_limit(500);
session_start();
$host = "localhost";
$username = "root";
$password = "";
$dbname = "spotify-api";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
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
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <div id="result"><?php
                        if (isset($_SESSION['key'])) {
                            echo $_SESSION['key'];
                            unset($_SESSION['key']);
                        }
                        ?></div>
    <div id="error">
        <?php
        if (isset($_SESSION['keyr'])) {
            echo $_SESSION['keyr'];
            unset($_SESSION['keyr']);
        }
        ?>
    </div>

    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <a href="delete.php" class="btn" style=" color:white;display: flex;justify-content: center;align-items: center;width:150px;margin:70px auto;" cd>Home Page</a>
    <div class="row row-cols-1 row-cols-md-3 g-4 " style="margin:15px;">
        <?php
        $id = 0;
        $sql = "SELECT * FROM `musicinfo`";
        $result = $conn->query($sql);
        $i = 7;
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col"id=' . $i . ' >';


            echo '<div class="forcard" data-tilt>';
            echo '<img src="' . $row['img'] . '" alt="user">';
            echo '<h1 style=" font-size:25px; text-align: center;" id=' . $i . '>' . $row['Trackname'] . '</h1>';
            echo '<h3 style=" font-size:20px;">' . $row['Artistname'] . '</h3>';
            echo '<h3>' . $row['reldate'] . '</h3>';


            echo '<form action="" method="POST" >';
            echo '<div class="row">';
            echo '<div class="col">';
            echo '<a href="' . $row['src'] . '" target="_blank" class="round-button col-sm" id="' . $id . '"><i class="fa fa-play fa-2x"></i></a>';
            echo '</div>';
            echo '<div class="col">';
            echo '<a href=./saveplaylist?id=' . $row['id'] . ' class="round-button col-sm"> <i class="far fa-save fa-2x"></i></a>';
            echo '</div>';
            echo '</div>';
            echo '</form>';


            echo '</div>';
            echo '</div>';
            $i = $i + 1;
        }
        ?>
    </div>


    <dialog id="dlogs" class="modalbox">
    
        <form method="dialog">
        <div class="row justify-content-md-center">
            <select>
                <option></option>
                <option>Happy</option>
                <option>Sad</option>
                <option>Surprised</option>
                <option>Angry</option>
                <option>Neutral</option>
            </select>
        </div>
            <menu>
            <div class="row">
            <div class="col-sm">
                <button id="cancel">Cancel</button>
            </div>
            <div class="col-sm">
                <button id="confirmBtn">Confirm</button>
            </div>
            </div>
            </menu>
        </form>
    </dialog>
    <script>
        var divs = document.getElementsByTagName('h1');
        var divArray = [];
        for (var i = 0; i < divs.length; i += 1) {
            divArray.push(divs[i].innerHTML);
        }
        console.log(divArray)
    </script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- tilt js -->
    <script src="./js/vanilla-tilt.min.js"></script>
    <script src="./js/count.js"></script>
</body>

</html>