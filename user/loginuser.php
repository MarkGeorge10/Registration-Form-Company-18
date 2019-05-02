
<?php
session_start();
class login {
    public $username;
    public $pass;

    public function checkEmailAndPassword(){
        if(empty($_POST['username']) || empty($_POST['password'])) {
          header("location: login.html");
        }
        else
        {
            return true;
        }
    }
    public function getEmailAndPass(){
        $this->username = $_POST['username'];
        $this->pass = $_POST['password'];
    }
    public function loginUser(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){

        $connect = mysql_connect("localhost", "root", "");
        $db = mysql_select_db("softwaretwo", $connect) or exit("<h1>Error</h1>".mysql_error());


        $strSQL  = "SELECT * from user_table where user_name = '$this->username' and password= '$this->pass'";
        $strResult = mysql_query($strSQL);
        $row = mysql_fetch_array($strResult,MYSQLI_ASSOC);
        $count = mysql_num_rows($strResult);



    if($count<1){
            echo "<h1> User Account not found</h1>";
          header("location: login.html");
                mysql_close();
        }
       else{

          $_SESSION['username'] = $row['user_name'];
          $_SESSION['password'] = $row['password'];
          $_SESSION['age'] =  $row['age'];
          $_SESSION['gender'] =  $row['gender'];
          $_SESSION['interest'] = $row['Interest'];


          if(  $_SESSION['username'] ===  "ADMIN" &&   $_SESSION['password'] === "admin" )
          {
            $user_arr= json_encode (array(
                "status" => true,
                "message" => "Admin Successfully Login!",

                "user_ID" => $row['user_ID'],
                "user_name" => $row['user_name'],

            ));

            //echo 'admin done';
          }



          $user_arr= json_encode (array(
              "status" => true,
              "message" => "Successfully Login!",

              "user_ID" => $row['user_ID'],
              "user_name" => $row['user_name'],

              "age" => $row['age'],
              "gender" => $row['gender'],
              "Interest" => $row['Interest'],
          ));

          echo 'done';



            mysql_close();
        }
        }
else{
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
