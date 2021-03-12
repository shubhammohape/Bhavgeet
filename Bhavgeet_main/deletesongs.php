<?php
session_start();
if(!isset($_GET['id']) || !isset($_GET['i'])){
die('Connection issues');
}
$id=$_GET['id'];
$host="localhost";
$username="root";
$password="";
$dbname="spotify-api";
$ids = $_GET['i'];

$conn=new mysqli($host,$username,$password,$dbname);
if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: ".$mysqli->connect_error;
    exit();
}
$sql = "DELETE FROM saveplaylist WHERE id=".$id."";
$result = $conn->query($sql);
if($result)
{
    $_SESSION['key']="Successfully Saved";
 header('Location:./playlist.php?i='.$ids);
}
else 
{
    $_SESSION['keyr']="There was an Error During the Process. Try Again";
    header('Location:./playlist.php?i='.$ids);
}

//$sql = "insert into playlist(Trackname) values(".$row[$id].")"
?>