<!DOCTYPE html>
<html>
<head>
  <title> Default </title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body { font-family: sans-serif;}

    .container
    {
      position:relative;
      width:500px;
      height:200px;
      top:50px;
      left:30%;
      padding-top: 20px;
      /*padding-top: 20px;
      padding-left: 200px;*/
      background-color: grey;
      text-align: center;
    }

    .close
    {
      position: absolute;
      right: 0;
      top: 0;
      font-size: 30px;
      font-weight: bold;
      color: black;
    }

    .close:hover, .close:focus
    {
      color: red;
      cursor: pointer;
    }

    .forgot
    {
      position:absolute;
      right: 5px;
      bottom: 10px;
    }

    .login_btn
    {
      position:absolute;
      left: 50%;
    }

/*
    .forgot::after
    {
      clear:both;
    }
*/
  </style>
</head>
<body>

  <div id="modal01" class="container">
      <span class="close" title="Close Modal" onclick="closeButton()">&times;</span>

      <form method="post" action="login.php">

        <h3>Sign In</h3>

        <p id="error_msg"></p>

        <p> <label for="username">Username: <input type = "text" id="signin_username" name="username" placeholder="Enter Username" required> </label></p>

        <p> <label for="pwd">Password: <input type = "password" id="signin_pwd" name="pwd" placeholder = "Enter Password" required> </label> </p>

        <p>
          <span class="forgot"> <a style="color:red">Forgot password?</a> </span>
        </p>

        <p> <input type="submit" class="login_btn"  name="login" value="OK"></p>


      </form>
  </div>

<script>
  function closeButton()
  {
    document.getElementById("modal01").style.display='none';
  }

</script>

<?php

ini_set('display_errors', 1); # only need to call these functions
error_reporting(E_ALL);       # one time

$doc = new DOMDocument();
$doc->loadHTML($_SERVER["PHP_SELF"]);

$doc->saveHTML();
$dv = $doc->getElementById('error_msg');
//echo ;

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

//Check username and password
if(isset($_POST["login"]))
{
  $username=trim($_POST["username"]);
  $password=trim($_POST["pwd"]);

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
          //echo "Admin";
        }
        else
        {

          //$notAdmin = innerHTML($dv);
          //$notAdmin ="Not Admin";
        }
    }
    else
    {
        //document.getElementById("error_msg").innerHTML="Password is incorrect.";

    }
  }
  else
  {
      //document.getElementById("error_msg").innerHTML="Username is incorrect.";
      //echo "Username is not correct.";


      //$dv->innerHTML="Username is incorrect.";
      //echo "Username is not correct.";
      $dv->nodeValue="Username is not correct.";
  }

}

?>

</body>
</html>
