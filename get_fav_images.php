
<!DOCTYPE html>
<html>
<head>
  <title> Get Images </title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body { font-family: sans-serif;}

  </style>
</head>
<body>

<?php

ini_set('display_errors', 1); # only need to call these functions
error_reporting(E_ALL);       # one time

$server = "localhost";
$username = "root";
$pwd = "jeffhu@527";
$db = "gallery";

//echo "Asd";

//Create Connections


$conn=new mysqli($server, $username, $pwd,$db);

if ($conn->connect_error)
{
  die("Connection failed: " . $conn->connect_error);
}


//Write SQL



$url1="All/";

$sql= "SELECT * FROM favorites";

$result = $conn->query($sql);

if ($result->num_rows > 0)
{
  while($row = $result->fetch_assoc())
  {
      /*Start of Define ResultSet*/

      echo "<img src=".$url1.$row["Image"]." class=\"middle_content\"". ">";

      /*End of Define ResultSet*/

  }
}
$conn->close();


?>




</body>
</html>
