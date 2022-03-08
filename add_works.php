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

$max_favs=3;
$doc = new DOMDocument();
$doc->loadHTMLFile("manager.html");
$dvMsg = $doc->getElementById('display_msg2');

//Create Connections

$conn=new mysqli($server, $username, $pwd,$db);

if ($conn->connect_error)
{
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST["add_to_work"]))
{
  global $max_favs;
  global $doc;

  $wID=$_POST["wID"];
  $wName=$_POST["wName"];
  $wCat=$_POST["wCat"];
  $wPrice=$_POST["wPrice"];
  $wQnty=$_POST["wQnty"];
  $wSize=$_POST["wSize"];
  $wImg=$_POST["wImg"];
  //$fav=$_POST["favorite"];

  /*
  echo "ID = ".$wID."<br>";
  echo "Name = ".$wName."<br>";
  echo "Category = ".$wCat."<br>";
  echo "Price = ".$wPrice."<br>";
  echo "Quantity = ".$wQnty."<br>";
  echo "Size = ".$wSize."<br>";
  echo "Image = ".$wImg;
  */

  //echo "ID = $wID";

  //echo "Favorite = ".$fav;


  $sql = "INSERT INTO `works`(`ID`, `Name`, `Category`, `Price`, `Quantity`, `Size`, `Image`) VALUES (?,?,?,?,?,?,?)";

  $stmt=$conn->prepare($sql);
  $stmt -> bind_param("issdiss", $wID, $wName, $wCat,$wPrice,$wQnty,$wSize,$wImg);
  $result = $stmt->execute();

  if ($result)
  {
    //echo "New work created successfully";

    if (!empty($_POST["favorite"]))
    {
      $sql1="SELECT COUNT(wID) AS 'nRows' from `favorites`";

      $result1=$conn->query($sql1);
      $row = $result1->fetch_assoc();

      if($result1->num_rows == 0 || ($result1->num_rows != 0 && $row['nRows']<$max_favs))
      {
        $sql2="INSERT INTO`favorites`(`wID`,`Image`) VALUES ('" .$wID."','".$wImg."')";
        $result2 = $conn->query($sql2);

        $dvMsg->nodeValue="Add Work Success!";

      }
      else
      {
          $dvMsg->nodeValue="Add Work Failed! Over Limit!";

      }
    }
    else
    {
      $dvMsg->nodeValue="Add Work Success!";
    }

  }
  else
  {

    $dvMsg->nodeValue="Add Work Failed!";
  }
  $dv = $doc->getElementById('add_works');
  $dvS = $doc->getElementsByTagName('div');
  foreach ($dvS as $value)
  {
    $value->setAttribute('style','display:none');
  }
  $dv->setAttribute('style','display:block');
  echo $doc->saveHTML();

}



$conn->close();

?>
