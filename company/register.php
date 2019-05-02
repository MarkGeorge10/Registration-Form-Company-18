<?php
//include("verficationControler.php");

$companynam = $_POST['Cname'];
$email = $_POST['email'];
$pass = $_POST['password'];
$location = $_POST['location'];
$number_employees = $_POST['number_employees'];
$interest = $_POST['interest'];


//$mycontrol = new verficationControler();
//$mycontrol->setUserData($companynam,$email,$pass,$location,$number_employees,$interest);


if(empty($companynam)||empty($email)||empty($pass)||empty($location)
  ||empty($number_employees)||empty($interest)){
    session_destroy();
    header("location: signup.html");
    return false;
}

else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    session_destroy();
    header("location: signup.html");
    return false;
}
else if($number_employees<0){
    session_destroy();
    header("location: signup.html");
    return false;
}
else{


  $connect = mysql_connect("localhost", "root", "");
  $db = mysql_select_db("softwaretwo", $connect) or exit("<h1>Error</h1>".mysql_error());
  $strSQL  = "select email, password from company_table";
  $strResult = mysql_query($strSQL);

  $_GLOBAL['flag'] =true;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
      while($fch = mysql_fetch_array($strResult))
      {
          $DBemail = $fch['email'];
          $DBpass = $fch['password'];
          if($DBemail ===  $email && $DBpass === $pass)
          {
              $_GLOBAL['flag']=false;
              mysql_close();
              header("location: signup.html");
              break;
          }
      }
      if($_GLOBAL['flag']){


          $_SESSION['companyname'] = $companynam;
          $_SESSION['email'] = $email;
          $_SESSION['password'] = $pass;
          $_SESSION['location'] = $location;
          $_SESSION['number_employees'] = $number_employees;
          $_SESSION['interest'] = $interest;

          $strSQL  = "insert into company_table (company_name,email,password,location,numberemployee,Interest) values('$companynam','$email','$pass','$location','$number_employees','$interest');";
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
