<?php
header("Content-Type: application/json; charset=UTF-8");

require 'galClass.php';

ini_set('display_errors', 1); # only need to call these functions
error_reporting(E_ALL);       # one time

//Write SQL

$url="All/";

/*
if(isset($_POST["join"]))
{

  $cus_fName=$_POST["firstname"];
  $cus_lName=$_POST["lastname"];
  $cus_email=$_POST["email"];
  $cus_pwd=$_POST["pwd"];

  $cus = new Customer();
  $cus->setCustomer(array($cus_fName,$cus_lName,$cus_email,$cus_pwd));
  $result=$cus->addCustomer();

  if ($result)
  {
    echo "New record created successfully";
  }
  else
  {
    echo "Error: Customer exists";
  }
}

if(isset($_POST["send"]))
{
  $cus = new Customer();
  $cus->setCusEmail($_POST["email"]);
  $result=$cus->searchEmail($_POST["email"]);

  if($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      echo "<h1>Email Verification Link Has Been Sent!</h1> <p>We send verification link on your providing email address please confirm your email address and login to your account.</p>";
    }
  }
  else
  {
      echo "<h1>Email not found.</h1>";
  }
}

if(isset($_POST["login"]))
{
  $cus = new Customer();
  $cus->setCusEmail($_POST["email"]);
  $cus->setCusPwd($_POST["pwd"]);
  $result=$cus->customerLogin($_POST["email"],$_POST["pwd"]);

  if($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      echo "<h1>Welcome!</h1>";
    }
  }
  else
  {
      echo "<h1>Email or password is incorrect.</h1>";
  }
}
*/

if(isset($_REQUEST["cus"]))
{
  $obj = json_decode($_REQUEST["cus"]);

  $cus = new Customer();
  $cus->setCustomer(array($obj->fName,$obj->lName,$obj->email,$obj->pwd));
  $result=$cus->updateCustomer($obj->email);

  echo $result;

}

if(isset($_REQUEST["total"]) && isset($_REQUEST["email"]))
{
  $orderTotal = $_REQUEST["total"];
  $cus_em = $_REQUEST["email"];

  $cus = new Customer();

  $result=$cus->updateBalance($cus_em,$orderTotal);
  echo $result;

  //echo $orderTotal . " and " . $cus_em;
}

if(isset($_REQUEST["cOrder"]))
{
  $obj = json_decode($_REQUEST["cOrder"], false);

  $d_str = date("Y-m-d");

  $cusOrder = new CustomerOrder();

  $arr = [];
  $arr['uID'] = $obj->uID;
  $arr['shipping_addr'] = $obj->address;
  $arr['pc'] = $obj->postalCode;
  $arr['phone_no'] = $obj->phoneNo;
  $arr['order_date'] = strval($d_str);
  $r = rand(1000,9999);
  $result=$cusOrder->searchOrderID($r);
  $totalAmt=0;

  while($result->num_rows > 0)
  {
    $r = rand(1000,9999);
    $result=$cusOrder->searchOrderID($r);
  }
  $arr['oID'] = $r;

  foreach(($obj->totalItems) as $item)
  {
    $arr['pID'] = $item->pID;
    $arr['pQty'] = $item->pQty;
    $arr['pSize'] = $item->pSize;
    $arr['pAmt'] = $item->subTotal;

    $cusOrder->setCusOrder($arr);
    $result=$cusOrder->addCusOrder();

    $totalAmt += $arr['pAmt'];

    //echo $item->pID;

    //echo (json_encode($item));
  }

  $inv_no = produceInvoice($arr['uID'],$arr['oID'],$totalAmt);
  //showInvoice($inv_no,$obj);
  echo $inv_no;
}


if(isset($_REQUEST["x"]))
{
  $obj = json_decode($_REQUEST["x"]);

  $cus = new Customer();
  $cus->setCustomer(array($obj->fName,$obj->lName,$obj->email,$obj->pwd,$obj->balance));
  $result=$cus->addCustomer();

  echo $result;
  /*
  if ($result)
  {
    //echo $obj->fName . " " . $obj->lName . ", " . $obj->email . ", " . $obj->pwd;
    echo $result;
  }
  else
  {
    echo "Error: Customer exists";
  }
  */
}

if(isset($_REQUEST["y"]))
{
  $obj = json_decode($_REQUEST["y"]);

  $cus = new Customer();
  $cus->setCusEmail($obj->email);
  $result=$cus->searchEmail($obj->email);

  if ($result->num_rows > 0)
  {

  }
  else
  {
    echo "Email Address is not correct.";
  }

  //echo json_encode($result);
}

if(isset($_REQUEST["z"]))
{
  $obj = json_decode($_REQUEST["z"], false);

  $cus = new Customer();
  $cus->setCusEmail($obj->email);
  $cus->setCusPwd($obj->pwd);

  $result1=$cus->searchEmail($obj->email);

  //Example

  //$arr = array("First_Name"=>"Kevin","Email"=>"kevin@hotmail.com");
  //echo (json_encode($arr));

  if ($result1->num_rows > 0)
  {
    $result2=$cus->searchCustomer($obj->email,$obj->pwd);

    if ($result2->num_rows > 0)
    {
      $rows = $result2->fetch_all(MYSQLI_ASSOC);
      //$rows = $result2->fetch_assoc();

      //echo $rows;
      echo (json_encode($rows));
      //echo json_encode("Water");

    }
    else
    {
      echo (json_encode("Password is not correct."));
    }
  }
  else
  {
    echo (json_encode("Email Address is not correct."));
  }

  //$result=$cus->customerLogin($obj->email,$obj->pwd);

  //echo json_encode($result);
}

if(isset($_REQUEST["category"]))
{
  $wCat = $_REQUEST["category"];

  $work = new Work();
  $work->setCat($wCat);
  $result=$work->getWorkByCat($wCat);

  if ($result->num_rows > 0)
  {
    showAll($result);
  }

}

if(isset($_REQUEST["fav_img"]))
{
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

function produceInvoice($uID,$oID,$pAmt)
{
  $cusInvoice = new Invoice();

  $invoiceNo=$cusInvoice->getInvoiceNo()+1;

  $arr = [];
  $arr['inv_no'] = $invoiceNo;
  $arr['uID'] = $uID;
  $arr['oID'] = $oID;
  $arr['tAmt'] = $pAmt;

  $cusInvoice->setInvoice($arr);
  $result=$cusInvoice->addInvoice();

  return $invoiceNo;
}



function showAll($result)
{
  global $url;
  $s_html="";

  while($row = $result->fetch_assoc())
  {
    $s_html.='<div class="column">';
    $s_html.='<img src="'.$url.$row["Image"].'" id='.$row["ID"].' alt="'.$row["Name"].'" style="width:100%;height:200px" onclick="displayImg(this)">';
    $s_html.="<p>".$row["Name"]."</p>";
    $s_html.="<p style='font-weight: bold;'>$".$row["Price"]."</p>";
    $s_html.="</div>";
  }
  echo $s_html;
}

//$conn->close();

?>
