<!--
This page for admin to create manager
-->
<?php

ini_set('display_errors', 1); # only need to call these functions
error_reporting(E_ALL);       # one time

$doc = new DOMDocument();
$doc->loadHTMLFile("admin.html");
$dv = $doc->getElementById('display_msg');

//Define Variables
$server = "localhost";
$username = "root";
$pwd = "jeffhu@527";
$db = "gallery";

  if(isset($_POST["login"]))
  {
    $username=trim($_POST["a_name"]);
    $password=trim($_POST["a_pwd"]);

    //Create Connections
    $conn=new mysqli($server, $username, $pwd,$db);

    if ($conn->connect_error)
    {
      die("Connection failed: " . $conn->connect_error);
    }

    //$sql= "SELECT * FROM administrator WHERE Username =" . "\"" . $username . "\" AND Password=" . "\"" . $password . "\"";
    //$result = $conn->query($sql);
    $sql1= "SELECT * FROM administrator WHERE Username =" . "\"" . $username . "\"";
    $sql2= "SELECT * FROM administrator WHERE Password =" . "\"" . $password . "\"";
    $result = $conn->query($sql1);
    if ($result->num_rows > 0)
    {
      $result = $conn->query($sql2);

      if ($result->num_rows > 0)
      {
          if($username == "admin")
          {
            newManager();
          }
          else
          {
            //TO DO: Open inventory management
            global $doc;
            $doc->loadHTMLFile("manager.html");
            echo $doc->saveHTML();
          }
      }
      else
      {
          //$doc = new DOMDocument();
          //$doc->loadHTMLFile("login.html");
          //$dv = $doc->getElementById('display_msg');

          $dv->nodeValue="Password is not correct.";
          echo $doc->saveHTML();
      }
    }
    else
    {
        //$doc = new DOMDocument();
        //$doc->loadHTMLFile("login.html");
        //$dv = $doc->getElementById('display_msg');

        $dv->nodeValue="Username is not correct.";
        echo $doc->saveHTML();
    }
  }

  function newManager()
  {
    global $doc;
    $doc->loadHTMLFile("newManager.html");
    echo $doc->saveHTML();

    //addManager();
  }

?>
