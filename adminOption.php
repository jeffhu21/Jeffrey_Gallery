<!--
Create new manager and add to administrator table in the database
-->
<?php

require 'galClass.php';

ini_set('display_errors', 1); # only need to call these functions
error_reporting(E_ALL);       # one time

$doc = new DOMDocument();
$doc->loadHTMLFile("adminOption.html");
$dvMsg = $doc->getElementById('add_msg');
$dvMsg2 = $doc->getElementById('rm_msg');
$dvMsg3 = $doc->getElementById('sch_msg');

if(isset($_POST["mng"]))
{
  switch ($_POST["mng"])
  {
    case 'AddNewManager':

    $username=trim($_POST["username"]);
    $email=trim($_POST["email"]);
    $password=trim($_POST["pwd"]);
    $phone=trim($_POST["phone"]);

    $manager = new Manager();
    $manager->setManager(array($username,$email,$password,$phone));
    $result1=$manager->addManager();

    if($result1)
    {
      $dvMsg->nodeValue="User is created successfully!";
      //echo $doc->saveHTML();
    }
    else
    {
      $dvMsg->nodeValue="User exists.";
      //echo $doc->saveHTML();
    }
    popUpForm("add_mng");
    break;

    case 'RemoveManager':

      $mnger = new Manager();
      $mnger->setPerson(trim($_POST["username"]),trim($_POST["pwd"]));
      //$result=$mnger->searchManager($_POST["username"],trim($_POST["pwd"]));

      $result=$mnger->removeManager(trim($_POST["username"]),trim($_POST["pwd"]));

      if($result)
      {
        $dvMsg2->nodeValue="User is removed successfully!";
      }
      else
      {
        $dvMsg2->nodeValue="User does not exist.";
      }


      popUpForm("remove_mng");
      break;

    case 'SearchManager':

    $mnger = new Manager();

    //echo $_POST["sch_op"]."<br>";
    //echo $_POST["lb"];

    $result=$mnger->searchManager($_POST["sch_op"],$_POST["lb"]);


    if($result->num_rows > 0)
    {
      $dvMsg3->nodeValue="USER EXISTS!";

    }
    else
    {
        $dvMsg3->nodeValue="NOT FOUND!";
    }
    popUpForm("search_mng");
    break;
    

    //$row=$result->fetch_assoc();

    //echo $row["Phone_No"];

    /*
    if($_POST["sch_op"]=="Username")
    {
      $mnger->setUsername(trim($_POST["lb"]));
    }
    else if($_POST["sch_op"]=="Email")
    {

    }
    */

    /*
    $mnger = new Manager();
    $mnger->setUsername(trim($_POST["username"]));
    $result=$mnger->searchManager(trim($_POST["username"]));


    if($result->num_rows > 0)
    {
      $dvMsg3->nodeValue="USER EXISTS!";

    }
    else
    {
        $dvMsg3->nodeValue="NOT FOUND!";
    }
    popUpForm("search_mng");
    break;
    */
  }
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
  echo $doc->saveHTML();
}


?>
