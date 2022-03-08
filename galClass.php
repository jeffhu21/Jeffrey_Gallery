<?php

header("Content-Type: application/json; charset=UTF-8");

//Gallery Class
class Gallery
{
  /*
  define($server,"localhost");
  define($username,"root");
  define($pwd,"jeffhu@527");
  define($db,"gallery");
  */

  //Define Variables

  public $server="localhost";
  public $username="root";
  public $pwd="jeffhu@527";
  public $db="gallery";
  public $conn;

  function open()
  {
    //Create Connections

    $this->conn=new mysqli($this->server, $this->username, $this->pwd,$this->db);

    if ($this->conn->connect_error)
    {
      die("Connection failed: " . $this->conn->connect_error);
    }
    return $this->conn;
  }

  function close()
  {
    //Close Connections

    $this->conn->close();
  }

}


//Customer Class
class Customer extends Gallery
{
  private $row = array();

  private $cus_email;
  private $cus_pwd;
  //private $cus_bal;

  function setCustomer($arr)
  {

    $this->row["First_Name"] = $arr[0];
    $this->row["Last_Name"] = $arr[1];
    $this->row["Email_Address"] = $arr[2];
    $this->row["Password"] = $arr[3];
    $this->row["Balance"] = $arr[4];
  }

  /*
  function setCusName($fname,$lname)
  {
    $cus_fname=$fname;
    $cus_lname=$lname;
  }
  */

  function setCusEmail($email)
  {
    $cus_email=$email;
  }

  function setCusPwd($pwd)
  {
    $cus_pwd=$pwd;
  }

  /*
  function setCusBal($bal)
  {
    $cus_bal=$bal;
  }
  */

  function addCustomer()
  {
    $conn = $this->open();

    $sql= "INSERT INTO `customer`(`First_Name`, `Last_Name`, `Email_Address`, `Password`, `Balance`) VALUES (?,?,?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt -> bind_param("ssssd", $this->row['First_Name'], $this->row['Last_Name'], $this->row['Email_Address'],$this->row['Password'],$this->row['Balance']);
    $result = $stmt->execute();

    return $result;
  }

  function searchEmail($email)
  {
    $conn = $this->open();
    $sql = "SELECT * FROM customer WHERE Email_Address='".$email."'";
    $result = $conn->query($sql);
    return $result;
  }

  function searchCustomer($email,$pwd)
  {
    $conn = $this->open();
    $sql = "SELECT * FROM customer WHERE Email_Address =" . "\"" . $email . "\" AND Password=" . "\"" . $pwd . "\"";
    $result = $conn->query($sql);
    return $result;
  }

  function updateCustomer($email)
  {
    $conn = $this->open();

    $sql = "UPDATE `customer` SET `First_Name`=?, `Last_Name`=?,`Password`=? WHERE Email_Address='".$email."'";
    $stmt=$conn->prepare($sql);
    $stmt -> bind_param("sss", $this->row['First_Name'], $this->row['Last_Name'], $this->row['Password']);
    $result = $stmt->execute();

    return $result;

  }

  function updateBalance($email,$total)
  {
    $conn = $this->open();

    $sql = "UPDATE `customer` SET Balance=Balance-".$total." WHERE Email_Address='".$email."'";
    $result = $conn->query($sql);
    return $result;
  }

  //function customerLogin($email,$pwd)
  //{

  //  $conn = $this->open();
  //  $result1 = $this->searchEmail($email);
    //$sql = "SELECT * FROM customer WHERE Email_Address =" . "\"" . $email . "\" AND Password=" . "\"" . $pwd . "\"";
  //  if ($result1->num_rows > 0)
  //  {
      //$result2 = $conn->query($sql);
  //    $result2 = $this->searchCustomer($email,$pwd);

  //    return $result2;
      /*
      if ($result2->num_rows > 0)
      {

      }
      else
      {
        echo "Password is not correct";
      }
      */
  //  }
  //  else
  //  {
  //    echo "Email Address is not correct";
  //  }


  //}

}

//CustomerOrder Class
class CustomerOrder extends Gallery
{
  private $row = array();

  function setCusOrder($arr)
  {
    $this->row["User_ID"] = $arr['uID'];
    $this->row["Product_ID"] = $arr['pID'];
    $this->row["Shipping_Address"] = $arr['shipping_addr'];
    $this->row["Quantity"] = $arr['pQty'];
    $this->row["Amount"] = $arr['pAmt'];
    $this->row["Size"] = $arr['pSize'];
    $this->row["Order_Date"] = $arr['order_date'];
    $this->row["Order_ID"] = $arr['oID'];
    $this->row["Postal_Code"] = $arr['pc'];
    $this->row["Phone_No"] = $arr['phone_no'];
  }

  function addCusOrder()
  {
    $conn = $this->open();

    $sql= "INSERT INTO `customer_order`(`User_ID`, `Product_ID`, `Shipping_Address`, `Quantity`, `Amount`, `Size`, `Order_Date`, `Order_ID`, `Postal_Code`, `Phone_No`) VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt -> bind_param("sisidssiss", $this->row['User_ID'], $this->row['Product_ID'], $this->row['Shipping_Address'],$this->row['Quantity'],$this->row['Amount'],$this->row['Size'],$this->row['Order_Date'],$this->row['Order_ID'],
                        $this->row['Postal_Code'],$this->row['Phone_No']);
    $result = $stmt->execute();

    return $result;
  }

  function searchOrderID($o_id)
  {
    $conn = $this->open();
    $sql = "SELECT * FROM customer_order WHERE Order_ID =". $o_id;
    $result = $conn->query($sql);

    return $result;
  }

}

//Invoice Class
class Invoice extends Gallery
{
  private $row = array();

  function setInvoice($arr)
  {
    $this->row["Invoice_No"] = $arr['inv_no'];
    $this->row["User_ID"] = $arr['uID'];
    $this->row["Order_ID"] = $arr['oID'];
    $this->row["Total_Amount"] = $arr['tAmt'];
  }

  function addInvoice()
  {
    $conn = $this->open();

    $sql= "INSERT INTO `invoice`(`Invoice_No`, `User_ID`, `Order_ID`, `Total_Amount`) VALUES (?,?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt -> bind_param("isid", $this->row['Invoice_No'], $this->row['User_ID'], $this->row['Order_ID'],$this->row['Total_Amount']);
    $result = $stmt->execute();
  }

  function getInvoiceNo()
  {
    $conn = $this->open();

    $sql="SELECT COUNT(*) AS 'nRows' from `invoice`";
    $result=$conn->query($sql);
    $rw = $result->fetch_assoc();

    if($result->num_rows == 0)
    {
      return 0;
    }
    else
    {
      return $rw['nRows'];
    }

  }

}

//Manager Class
class Manager extends Gallery
{
  //private $row = array("Username"=>' ',"Email"=>' ',"Password"=>' ',"Phone_No"=>' ');
  private $row = array();

  private $uname;
  private $email;
  private $password;
  private $phone;

  function setManager($arr)
  {
    $this->row["Username"] = $arr[0];
    $this->row["Email"] = $arr[1];
    $this->row["Password"] = $arr[2];
    $this->row["Phone_No"] = $arr[3];
  }

  function setUsername($username)
  {
    $uname=$username;
  }

  function setEmail($em)
  {
    $email=$em;
  }

  function setPhoneNo($phone_no)
  {
    $phone=$phone_no;
  }

  function setPerson($username,$pwd)
  {
    $uname=$username;
    $password=$pwd;
  }

  function searchManager($col,$val)
  {
    $conn = $this->open();
    $sql = "SELECT * FROM administrator WHERE ". $col."='".$val."'";
    //echo $sql;
    $result = $conn->query($sql);
    return $result;
  }

  /*
  function searchUsername($searchUN)
  {
    $conn = $this->open();
    $sql = "SELECT * FROM administrator WHERE Username='".$searchUN."'";
    $result = $conn->query($sql);
    return $result;
  }

  function searchEmail($searchEM)
  {
    $conn = $this->open();
    $sql = "SELECT * FROM administrator WHERE Email='".$searchEM."'";
    $result = $conn->query($sql);
    return $result;
  }

  function searchPhoneNo($searchPhoneNo)
  {
    $conn = $this->open();
    $sql = "SELECT * FROM administrator WHERE Phone_No='".$searchPhoneNo."'";
    $result = $conn->query($sql);
    return $result;
  }
  */

  function addManager()
  {
    $conn = $this->open();

    $sql= "INSERT INTO `administrator`(`Username`, `Email`, `Password`, `Phone_No`) VALUES (?,?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt -> bind_param("ssss", $this->row['Username'], $this->row['Email'], $this->row['Password'],$this->row['Phone_No']);
    $result = $stmt->execute();

    return $result;
  }

  function removeManager($removeUN,$removePwd)
  {
    $conn = $this->open();

    $sql = "DELETE FROM `administrator` WHERE Username='".$removeUN."'AND Password='".$removePwd."'";
    $result=$conn->query($sql);
    return $result;
  }

}

//Work Class
class Work extends Gallery
{
  private $row = array();
  private $ID;
  private $cat;

  function setWork($arr)
  {
    $this->row["ID"] = $arr[0];
    $this->row["Name"] = $arr[1];
    $this->row["Category"] = $arr[2];
    $this->row["Price"] = $arr[3];
    $this->row["Quantity"] = $arr[4];
    $this->row["Size"] = $arr[5];
    $this->row["Image"] = $arr[6];
  }

  function setID($wID)
  {
    $ID=$wID;
  }

  function setCat($wCat)
  {
    $cat=$wCat;
  }

  function addWorks()
  {
    $conn = $this->open();

    $sql = "INSERT INTO `works`(`ID`, `Name`, `Category`, `Price`, `Quantity`, `Size`, `Image`) VALUES (?,?,?,?,?,?,?)";

    $stmt=$conn->prepare($sql);
    //$stmt -> bind_param("issdiss", $this->wID, $this->wName, $this->wCat,$this->wPrice,$this->wQnty,$this->wSize,$this->wImg);
    $stmt -> bind_param("issdiss", $this->row['ID'], $this->row['Name'], $this->row['Category'],$this->row['Price'],$this->row['Quantity'],$this->row['Size'],$this->row['Image']);
    $result = $stmt->execute();
    //$this->close();

    return $result;
  }

  function removeWorks($removeID)
  {
    $conn = $this->open();
    $sql = "DELETE FROM `works` WHERE ID=".$removeID;
    $result=$conn->query($sql);
    return $result;
  }

  function getWorkByCat($searchCat)
  {
    $conn = $this->open();
    $sql = "SELECT * FROM works WHERE Category='".$searchCat."'";
    $result = $conn->query($sql);
    //$row=$result->fetch_assoc();
    //echo $row["Category"];
    return $result;
  }

  function getWorkById($searchID)
  {
    $conn = $this->open();
    $sql = "SELECT * FROM works WHERE ID=".$searchID;
    $result = $conn->query($sql);
    return $result;
  }

}

//Favorite Class
class Favorite extends Gallery
{
  private $max_favs=7;

  private $row = array();

  private $ID;

  function setFav($arr)
  {
    $this->row["wID"] = $arr[0];
    $this->row["Image"] = $arr[1];
  }

  function setID($wID)
  {
    $ID=$wID;
  }

  function noOfRows()
  {
    $conn = $this->open();
    $sql="SELECT COUNT(wID) AS 'nRows' from `favorites`";
    $result=$conn->query($sql);
    $rw = $result->fetch_assoc();

    if($result->num_rows == 0)
    {
      return 0;
    }
    else
    {
      return $rw['nRows'];
    }
  }

  function selectAllFav()
  {
    $conn = $this->open();
    //$sql = "SELECT * FROM favorites";
    $sql = "SELECT favorites.wID,works.Name,favorites.Image FROM favorites LEFT JOIN works ON favorites.wID = works.ID";
    $result = $conn->query($sql);
    return $result;
  }

  function searchFav($searchID)
  {
    $conn = $this->open();
    $sql = "SELECT * FROM favorites WHERE wID=".$searchID;
    //$sql = "SELECT favorites.wID,works.Name,favorites.Image FROM favorites INNER JOIN works ON favorites.wID = works.ID WHERE wID=".$searchID;
    $result = $conn->query($sql);
    return $result;
  }

  function addFav()
  {
    $conn = $this->open();

    //$sql="INSERT INTO`favorites`(`wID`,`Image`) VALUES (" .$this->row['wID'].",'".$this->row['Image']."')";
    //$result=$conn->query($sql);

    $sql = "INSERT INTO `favorites`(`wID`, `Image`) VALUES (?,?)";
    $stmt=$conn->prepare($sql);
    $stmt -> bind_param("is", $this->row['wID'], $this->row['Image']);
    $result = $stmt->execute();

    return $result;
  }

  function removeFav($removeID)
  {
    $conn = $this->open();
    $sql = "DELETE FROM `favorites` WHERE wID=".$removeID;
    $result=$conn->query($sql);
    return $result;
  }
}

?>
