<?php
session_start();
if(!isset($_GET['id'])){
die('Connection issues');
}
$id=$_GET['id'];
$host="localhost";
$username="root";
$password="";
$dbname="spotify-api";

$conn=new mysqli($host,$username,$password,$dbname);
if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: ".$mysqli->connect_error;
    exit();
}
$yo1="select * from `musicinfo` where id=".$id."";
$q=mysqli_query($conn,$yo1);
$n=mysqli_fetch_assoc($q);
$Trackname=$n['Trackname'];
$playlistname=$n['playlistname'];
$Artistname=$n['Artistname'];
$duration=$n['duration'];
$reldate=$n['reldate'];
$src=$n['src'];
$img=$n['img'];
$playlisturl=$n['playlisturl'];
$Artist2=$n['Artist2'];
echo $Trackname;
$sql = "INSERT INTO `saveplaylist` (playlistname,Artistname,Trackname,duration,src,img,reldate,playlisturl,Artist2) VALUES('$playlistname','$Artistname','$Trackname','$duration','$src','$img','$reldate','$playlisturl','$Artist2')";
$result = $conn->query($sql);
if($result)
{
    $_SESSION['key']="Successfully Saved";
 header('Location:./new.php');
}
else 
{
    $_SESSION['keyr']="There was an Error During the Process. Try Again";
    header('Location:./new.php');
}

//$sql = "insert into playlist(Trackname) values(".$row[$id].")"
?>