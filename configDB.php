<!DOCTYPE html>
<html>
<head>
  <title> Configure Database </title>
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

//Define Variables

$server = "localhost";
$username = "root";
$pwd = "jeffhu@527";
$db = "gallery";

$admin = "admin";
$adminPWD = "admin123";
$adminEmail= "";
$adminPhoneNo = "";


//Create Connections

$conn1=new mysqli($server, $username, $pwd);

if ($conn1->connect_error)
{
  die("Connection failed: " . $conn->connect_error);
}

//Write SQL


$sql= "CREATE DATABASE IF NOT EXISTS ". $db;

$result = $conn1->query($sql);

$conn1->close();

$conn=new mysqli($server, $username, $pwd,$db);


$sql= "CREATE TABLE IF NOT EXISTS Works(ID int(4) PRIMARY KEY, Name varchar(255), Category varchar(255),Price double precision, Quantity int, Size varchar(30), Image varchar(1000))";
$result = $conn->query($sql);

$sql= "CREATE TABLE IF NOT EXISTS Favorites(wID int(4),Image varchar(1000),FOREIGN KEY (wID) REFERENCES Works(ID))";
$result = $conn->query($sql);

$sql="CREATE TABLE IF NOT EXISTS administrator(Username varchar(255),Email varchar(255),Password varchar(255),Phone_No varchar(255),PRIMARY KEY(Username, Password))";
$result = $conn->query($sql);

$sql="CREATE TABLE IF NOT EXISTS customer(First_Name varchar(255),Last_Name varchar(255),Email_Address varchar(255) PRIMARY KEY,Password varchar(255),Balance double precision)";
$result = $conn->query($sql);


$sql="CREATE TABLE IF NOT EXISTS Customer_Order(User_ID varchar(255),Product_ID int(4),Shipping_Address varchar(255),Quantity int, Amount double precision, Size varchar(30), Order_Date varchar(1000), Order_ID int, Postal_Code varchar(30), Phone_No varchar(30),FOREIGN KEY (User_ID) REFERENCES customer(Email_Address),FOREIGN KEY (Product_ID) REFERENCES Works(ID))";
$result = $conn->query($sql);

$sql="CREATE TABLE IF NOT EXISTS invoice(Invoice_No int(4),User_ID varchar(255),Order_ID int,Total_Amount double precision,FOREIGN KEY (User_ID) REFERENCES customer(Email_Address))";
$result = $conn->query($sql);

$sql = "INSERT INTO `administrator`(`Username`, `Email`, `Password`, `Phone_No`) VALUES (?,?,?,?)";
$stmt=$conn->prepare($sql);
$stmt -> bind_param("ssss", $admin, $adminEmail, $adminPWD,$adminPhoneNo);
$result = $stmt->execute();

/*
if($result)
{
  echo "Success!";
}
else
{
  echo "Failed!";
}
*/

//$conn->close();

?>

</body>
</html>
