<?php

$id=$_GET['id'];
echo $id;
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
$sql = "INSERT INTO `playlist` (playlistname,Artistname,Trackname,duration,src,img,reldate,playlisturl,Artist2) VALUES('$playlistname','$Artistname','$Trackname','$duration','$src','$img','$reldate','$playlisturl','$Artist2')";
$result = $conn->query($sql);
if($result)
{
    echo 'true';
}
else 
{
    echo 'false';
}

//$sql = "insert into playlist(Trackname) values(".$row[$id].")"
?>