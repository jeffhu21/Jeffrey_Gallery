<!--
Add works into work table in the database
-->
<!DOCTYPE html>
<html>
<head>
  <title>Jeff's Gallery Management</title>
  <style>

  </style>
</head>
  <body>

  </body>
</html>

<!--
<script>
  window.onload = function(event)
  {
    loading();
  }
</script>
-->

<?php

//echo "<script>window.onload = function(event) { }</script>"

/*
function loading()
{
  echo "Loading";
}
*/

require 'galClass.php';
//require 'manager.html';

ini_set('display_errors', 1); # only need to call these functions
error_reporting(E_ALL);       # one time

$doc = new DOMDocument();
//if(empty($doc))
//{
//  echo "Load HTML";
  $doc->loadHTMLFile("manager.html");
//}

//$pImg = $doc->getElementById('display_img');

$dvMsg = $doc->getElementById('addW_msg');
$dvMsg2 = $doc->getElementById('searchW_msg');
$dvMsg3 = $doc->getElementById('updateW_msg');
$url = "All/";

if(isset($_POST["mng"]))
{
  switch ($_POST["mng"])
  {
    case 'AddWork':

      //global $doc;

      $wID=$_POST["wID"];
      $wName=$_POST["wName"];
      $wCat=$_POST["wCat"];
      $wPrice=$_POST["wPrice"];
      $wQnty=$_POST["wQnty"];
      $wSize=$_POST["wSize"];
      $wImg=$_POST["wImg"];

      //$Work = new Work($_POST["wID"],$_POST["wName"],$_POST["wCat"],$_POST["wPrice"],$_POST["wQnty"],$_POST["wSize"],$_POST["wImg"]);
      //$Work = new Work($_POST["wID"]);

      $work = new Work();
      $work->setWork(array($wID,$wName,$wCat,$wPrice,$wQnty,$wSize,$wImg));
      $result=$work->addWorks();

      //$Work->setWork($_POST["wID"],$_POST["wName"],$_POST["wCat"],$_POST["wPrice"],$_POST["wQnty"],$_POST["wSize"],$_POST["wImg"]);
      //$result=$Work->addWorks();

      if ($result)
      {
        if (!empty($_POST["favorite"]))
        {
          //popUpForm('update_fd');
          add_Favorites($wID,$wImg);

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
      popUpForm('add_works');
      break;

    case 'Search':

      //$Work = new Work($_POST["wID"]," "," "," "," "," "," ");
      //$Favorite = new Favorite($_POST["wID"]," "," "," "," "," "," ");
      $work = new Work();
      $work->setID($_POST["wID"]);

      $result=$work->getWork($_POST["wID"]);

      if($result->num_rows > 0)
      {
        //$dvMsg3->nodeValue="Remove Work From Favorite.";

        //showResult($result);

        showWork($result);
        //popUpForm('sch_works');

      }
      else
      {
          //echo "NOT FOUND!";
          $dvMsg2->nodeValue="NOT FOUND!";

      }
      popUpForm('sch_works');
      //popUpForm('rm_works');

      //document.getElementById(divID).style.display="block";
      break;

    case "Remove":

      $work = new Work();
      $favorite = new Favorite();
      $favorite->setID($_POST["wID"]);
      $result2=$favorite->searchFav($_POST["wID"]);
      //$resultRow=$result2->num_rows;

      if($result2->num_rows > 0)
      {
        $result3=$favorite->removeFav($_POST["wID"]);
      }
      else
      {
        $result4=$work->removeWorks($_POST["wID"]);

        if($result4)
        {
          $dvMsg2->nodeValue="Remove Successfully!";
        }
        else
        {
          $dvMsg2->nodeValue="Remove Failed!";
        }
      }


      global $doc;
      $doc->getElementById('rmW_img')->setAttribute("style","display:none");
      popUpForm('sch_works');

      break;

  case "LoadAll":

    $favorite = new Favorite();

    $result2 = $favorite->selectAllFav();
    if($result2->num_rows > 0)
    {
      showResult($result2);
    }
    else
    {
      $dvMsg3->nodeValue="NOT FOUND!";
    }
    popUpForm('update_fd');
    break;

  case "AddFavorites":

    //echo "Johnny!";

    $work = new Work();
    $result=$work->getWork($_POST["wID"]);

    if($result->num_rows > 0)
    {

      $row = $result->fetch_assoc();

      add_Favorites($_POST["wID"],$row["Image"]);

      //showWork($result);
      //$result->data_seek(0);
      //$doc->loadHTMLFile("manager.html");
      //showResult($result);

    }
    else
    {
      $dvMsg3->nodeValue="NOT FOUND!";
    }

    //add_Favorites($_POST["wID"],$wImg);
    popUpForm('update_fd');

    break;
  }
}



//$wID = $_REQUEST["q"];



//case '-':

  /*
  echo $_POST["rmID"];

  $favorite = new Favorite();
  $result=$favorite->removeFav($_POST["rmID"]);

  if($result)
  {
    $dvMsg2->nodeValue="Remove favorite success!";

  }
  else
  {
    $dvMsg2->nodeValue="Remove favorite failed!";
  }
  */
      /*
      $result=$favorite->removeFav($_POST["wID"]);

      if($result)
      {
        $dvMsg2->nodeValue="Remove favorite success!";
      }
      else
      {
        $dvMsg2->nodeValue="Remove favorite failed!";
      }
      */

  //echo $_POST["hmng"];
  //echo $_POST["lbl"];
  //popUpForm('sch_works');
  //break;

function add_Favorites($wID,$wImg)
{
  global $dvMsg;
  $favorite= new Favorite();
  $favorite->setFav(array($wID,$wImg));

  //$Favorite->addFavWorks();
  //$Favorite = new Favorite($_POST["wID"],$_POST["wImg"]);
  //$fav_rows = $Favorite->noOfRows();

  if($favorite->noOfRows()<$favorite->max_favs)
  {
    $result1=$favorite->addFav();

    if($result1)
    {
      $dvMsg->nodeValue="Add To Favorite Success!";
    }
    else
    {
      $dvMsg->nodeValue="Add To Favorite Failed!";
    }

  }
  else
  {
    $dvMsg->nodeValue="Add To Favorite Failed! Over Limit!";
    //popUpForm('update_fd');
  }
}

function showWork($result)
{
  global $doc,$url;
  while($row = $result->fetch_assoc())
  {
    $dvRm = $doc->getElementById('rmW_img');
    $dvRm->setAttribute("display","block");

    $inpt = $doc->getElementById('rm_wID');

    $inpt->setAttribute("value",$row["ID"]);

    $imgNode = $doc->createElement("img",$row["ID"]);
    $imgNode->setAttribute("src",$url.$row["Image"]);
    $imgNode->setAttribute("style","width:100%;height:auto");
    $imgNode->setAttribute("id",$row["ID"]);
    $imgNode->setAttribute("alt",$row["ID"]);

    $dvRm->appendChild($imgNode);
    //$imgNode->setAttribute("onclick","showWImg(this)");
  }

}

function showResult($result)
{
  global $doc,$url;
  //echo $result->num_rows;
  while($row = $result->fetch_assoc())
  {
    //echo $row["wID"];
    //echo "Shawn";
    $dvRm = $doc->getElementById('img_row');

    $elmDIV=$doc->createElement("div");
    $elmDIV->setAttribute("class","column");
    $dvRm->appendChild($elmDIV);

    $imgNode = $doc->createElement("img",$row["wID"]);
    $imgNode->setAttribute("src",$url.$row["Image"]);
    $imgNode->setAttribute("style","width:100%;height:auto");
    $imgNode->setAttribute("id",$row["wID"]);
    $imgNode->setAttribute("alt",$row["wID"]);
    $imgNode->setAttribute("onclick","showFImg(this)");

    $elmDIV->appendChild($imgNode);

    //$doc->saveHTML();

    //echo $doc->getElementById($row["wID"])->id;
  }
  //$doc->saveHTML();
}

function popUpForm($divID)
{
  global $doc;
  $dv = $doc->getElementById($divID);
  $dvS = $doc->getElementsByTagName('div');
  foreach ($dvS as $value)
  {
    $value->setAttribute('style','display:none');
  }
  $dv->setAttribute('style','display:block');



//  if($divID == 'rm_works')
//  {
  //  $img_IDs = $doc->getElementById('img_row');
    //$img_IDs->setAttribute('style','display:block');
    //$cDvS = $img_IDs->getElementsByTagName('div');

    $cDvS = $dv->getElementsByTagName('div');
    foreach ($cDvS as $value)
    {
      $value->setAttribute('style','display:block');
    }

    $expE=$doc->getElementById('expandedImg');

    if(empty($expE->getAttribute('src')))
    {
      //echo "Kevin";

      $expE->parentNode->setAttribute('style','display:none');
    }


  //}
  echo $doc->saveHTML();
  //$doc->saveHTML();
}

//if(isset($_REQUEST["s"]))
//{
  //echo $_REQUEST["s"];

//}

if(isset($_REQUEST["q"]))
{
  $wID = $_REQUEST["q"];

  $work = new Work();
  $favorite = new Favorite();
  $result=$favorite->removeFav($wID);

  if($result)
  {
    //$dvMsg3->nodeValue="Remove favorite success!";
    echo "Remove favorite success!";
  }
  else
  {
    //$dvMsg3->nodeValue="Remove favorite failed!";
    echo "Remove favorite failed!";
  }
  $result2=$work->removeWorks($wID);

  if($result2)
  {
    //$dvMsg3->nodeValue="Remove work success!";
    echo "Remove work success!";
  }
  else
  {
    //$dvMsg3->nodeValue="Remove work failed!";
    echo "Remove work failed!";
  }
}

//$conn->close();

?>
