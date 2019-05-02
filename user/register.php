<?php
//include("verficationControler.php");

$usernam = $_POST['Uname'];
$pass = $_POST['password'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$interest = $_POST['interest'];


//$mycontrol = new verficationControler();
//$mycontrol->setUserData($companynam,$email,$pass,$location,$number_employees,$interest);


if(empty($usernam)||empty($pass)||empty($age)||empty($gender)||empty($interest)){
    session_destroy();
    header("location: signup.html");
    return false;
}


else if($age<0){
    session_destroy();
    header("location: signup.html");
    return false;
}
else{


  $connect = mysql_connect("localhost", "root", "");
  $db = mysql_select_db("softwaretwo", $connect) or exit("<h1>Error</h1>".mysql_error());
  $strSQL  = "select user_name from user_table";
  $strResult = mysql_query($strSQL);

  $_GLOBAL['flag'] =true;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
      while($fch = mysql_fetch_array($strResult))
      {
          $DBusername = $fch['email'];

          if($DBusername ===  $usernam )
          {
              $_GLOBAL['flag']=false;
              mysql_close();
              header("location: signup.html");
              break;
          }
      }
      if($_GLOBAL['flag']){


          $_SESSION['username'] = $usernam;
          $_SESSION['password'] = $pass;
          $_SESSION['age'] = $age;
          $_SESSION['gender'] = $gender;
          $_SESSION['interest'] = $interest;

          $strSQL  = "insert into user_table (user_name,password,age,gender,Interest) values('$usernam','$pass','$age','$gender','$interest');";
          $strResult = mysql_query($strSQL);
          mysql_close();

        header("location: login.html");
          //header("location: posting.php");
      }

  }
  else
  {
      echo "<h1> You are not allowed to access this page directly</h1>";

      mysql_close();
  }



    return true;
}




?>
