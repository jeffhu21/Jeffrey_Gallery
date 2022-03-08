<!--
Create new manager and add to administrator table in the database
-->
<?php

require 'galClass.php';

ini_set('display_errors', 1); # only need to call these functions
error_reporting(E_ALL);       # one time

$doc = new DOMDocument();
$doc->loadHTMLFile("newManager.html");
$dv = $doc->getElementById('display_msg');

if(isset($_POST["add_mng"]))
{
  $username=trim($_POST["username"]);
  $email=trim($_POST["email"]);
  $password=trim($_POST["pwd"]);
  $phone=trim($_POST["phone"]);

  $manager = new Manager();
  $manager->setManager(array($username,$email,$password,$phone));
  $result1=$manager->addManager();

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
