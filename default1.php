<!-- Write you code here -->

<?php
require 'galClass.php';

ini_set('display_errors', 1); # only need to call these functions
error_reporting(E_ALL);       # one time

//$doc = new DOMDocument();
//$doc->loadHTMLFile("index.html");
//$dvCat = $doc->getElementById('eu_usa');

//Write SQL

$url="All/";

//$sql= "SELECT * FROM works";
//$sql= "SELECT * FROM works WHERE Category='EU/USA'";


if(isset($_REQUEST["category"]))
{
  $wCat = $_REQUEST["category"];

  $work = new Work();
  $work->setCat($wCat);
  $result=$work->getWorkByCat($wCat);

  if ($result->num_rows > 0)
  {
    //showResult($result);
    showAll($result);
  }

}

if(isset($_REQUEST["fav_img"]))
{
  //$wImg = $_REQUEST["fav_img"];

  $fav = new Favorite();
  $result=$fav->selectAllFav();

  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
        echo "<img src=".$url.$row["Image"]." class=\"slide_images\" style=\"height:350px\" ". ">";
    }
  }

}


function showAll($result)
{
  global $url;
  $s_html="";

  while($row = $result->fetch_assoc())
  {
    //echo $row["ID"]."<br>";
    $s_html.='<div class="column">';
    $s_html.='<img src="'.$url.$row["Image"].'" id='.$row["ID"].' alt="'.$row["Name"].'" style="width:100%;height:200px" onclick="displayImg(this)">';
    //$s_html.='<img src="'.$url.$row["Image"].'" style="width:100%;height:200px"">';
    $s_html.="<p>".$row["Name"]."</p>";
    $s_html.="<p style='font-weight: bold;'>$".$row["Price"]."</p>";
    $s_html.="</div>";
  }
  echo $s_html;
}



/*
function showResult($result)
{
  global $doc,$url;

  while($row = $result->fetch_assoc())
  {
      $dvImg = $doc->getElementById('r_col');
      $elmDIV=$doc->createElement("div");
      $elmDIV->setAttribute("class","column");
      $dvImg->appendChild($elmDIV);

      $imgNode = $doc->createElement("img");
      $imgNode->setAttribute("src",$url.$row["Image"]);
      $imgNode->setAttribute("style","width:100%;height:200px");
      $elmDIV->appendChild($imgNode);
      //echo $row["ID"];

      $pNode = $doc->createElement("p");
      $pNode->nodeValue=$row["Name"];
      $elmDIV->appendChild($pNode);

  }
  echo $doc->saveHTML()."<br>";
}
*/

//$conn->close();

?>
