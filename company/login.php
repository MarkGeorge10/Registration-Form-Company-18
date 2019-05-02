
<?php
session_start();
class login{
    public $email;
    public $pass;

    public function checkEmailAndPassword(){
        if(empty($_POST['email']) || empty($_POST['password'])) {
          header("location: login.html");
        }
        else
        {
            return true;
        }
    }
    public function getEmailAndPass(){
        $this->email = $_POST['email'];
        $this->pass = $_POST['password'];
    }
    public function loginUser(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){

        $connect = mysql_connect("localhost", "root", "");
        $db = mysql_select_db("softwaretwo", $connect) or exit("<h1>Error</h1>".mysql_error());


        $strSQL  = "SELECT * from company_table where email = '$this->email' and password= '$this->pass'";
        $strResult = mysql_query($strSQL);
        $row = mysql_fetch_array($strResult,MYSQLI_ASSOC);
        $count = mysql_num_rows($strResult);



        if($count === 1){

          $_SESSION['companyname'] = $row['company_name'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['password'] = $row['password'];
          $_SESSION['location'] =  $row['location'];
          $_SESSION['number_employees'] =  $row['numberemployee'];
          $_SESSION['interest'] = $row['Interest'];


          $user_arr= json_encode (array(
              "status" => true,
              "message" => "Successfully Login!",

              "company_ID" => $row['company_ID'],
              "company_name" => $row['company_name'],
              "email" => $row['email'],
              "location" => $row['location'],
              "numberemployee" => $row['numberemployee'],
              "Interest" => $row['Interest'],
          ));

          //echo $user_arr;
          


            mysql_close();
        }
        else{
            echo "<h1> User Account not found</h1>";
          //  header("location: login.html");
                mysql_close();
        }
    }
    else
    {

      $user_arr=array(
          "status" => false,
          "message" => "Invalid Username or Password!",
      );

      echo "<h1> You are not allowed to access this page directly</h1>";
      echo "<a href ='login.html'>Back to login page</a>";
    }
    print_r(json_encode($user_arr));
}
}

$user = new login();
if($user->checkEmailAndPassword()){
    $user->getEmailAndPass();
    $user->loginUser();
}





?>
