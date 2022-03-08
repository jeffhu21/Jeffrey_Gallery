<!--
Create new manager and add to administrator table in the database
-->
<!DOCTYPE html>
<html>
<head>
  <title> New Manager </title>
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

$doc = new DOMDocument();
$doc->loadHTMLFile("newManager.html");
$dv = $doc->getElementById('display_msg');

//Define Variables
$server = "localhost";
$username = "root";
$pwd = "jeffhu@527";
$db = "gallery";

if(isset($_POST["add_mng"]))
{
  $username=trim($_POST["username"]);
  $email=trim($_POST["email"]);
  $password=trim($_POST["pwd"]);
  $phone=trim($_POST["phone"]);

  //Create Connections
  $conn=new mysqli($server, $username, $pwd,$db);

  if ($conn->connect_error)
  {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql1= "INSERT INTO `administrator`(`Username`, `Email`, `Password`, `Phone_No`) VALUES (?,?,?,?)";
  $stmt1=$conn->prepare($sql1);
  $stmt1 -> bind_param("ssss", $username, $email, $password,$phone);
  $result1 = $stmt1->execute();

  if($result1)
  {
    $dv->nodeValue="User is created successfully!.";
    echo $doc->saveHTML();
  }
  else
  {
    $dv->nodeValue="User exists.";
    echo $doc->saveHTML();
  }
}


?>

</body>
</html>
