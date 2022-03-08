<!--
Add works into work table in the database
-->

<?php

ini_set('display_errors', 1); # only need to call these functions
error_reporting(E_ALL);       # one time

//Define Variables

$server = "localhost";
$username = "root";
$pwd = "jeffhu@527";
$db = "gallery";

//Create Connections

$conn=new mysqli($server, $username, $pwd,$db);

if ($conn->connect_error)
{
  die("Connection failed: " . $conn->connect_error);
}

//if(isset($_POST["rm_from_work"]))
//{
  $wID=$_POST["wID"];

  //echo "ID = $wID";
  $sql1 = "SELECT * FROM favorites WHERE wID=".$wID;
  $sql2 = "DELETE FROM `favorites` WHERE wID=".$wID;
  $sql3 = "DELETE FROM `works` WHERE ID=".$wID;
  $result1 = $conn->query($sql1);

  if ($result1->num_rows > 0)
  {
    $result2 = $conn->query($sql2);

    /*
    if ($result2)
    {
      echo "Remove favorite success!";
    }
    else
    {
      echo "Remove favorite failed!";
    }
    */
  }
  else
  {
    $result3 = $conn->query($sql3);
    /*
    if ($result3)
    {
      echo "Remove work success!";
    }
    else
    {
      echo "Remove work failed!";
    }
    */
  }





//}

$conn->close();

?>
