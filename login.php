<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"></script> 
    <title>Login</title>
</head>
<body>
    <?php

    //learn from w3schools.com
    //Unset all the server side variables

    session_start();

    $_SESSION["user"]="";
    $_SESSION["usertype"]="";
    
    // Set the new timezone
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');

    $_SESSION["date"]=$date;
    

    //import database
    include("connection.php");


    if($_POST){

        $email=$_POST['useremail'];
        $password=$_POST['userpassword'];
        
        // $error='<div for="promter" class="input-field"></div>';
        // echo '<script>alert("")</script>';

        $result= $database->query("select * from webuser where email='$email'");
        if($result->num_rows==1){
            $utype=$result->fetch_assoc()['usertype'];
            if ($utype=='p'){
                $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
                if ($checker->num_rows==1){

                    //   Patient dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='p';
                    
                    header('location: patient/index.php');

                }else{
                  // echo '<script>alert("Wrong credentials: Invalid email or password")</script>';
                  $showAlert = true;
                  $alertMessage = "Wrong credentials: Invalid email or password";
                 
                }

            }elseif($utype=='a'){
                $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
                if ($checker->num_rows==1){


                    //   Admin dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='a';
                    
                    header('location: admin/index.php');

                }else{
                    // $msg =  "Invalid email or password";
                  // echo '<script>alert("Invalid email or password")</script>';
                  $showAlert = true;
                  $alertMessage = "Invalid email or password";
                }


            }elseif($utype=='d'){
                $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
                if ($checker->num_rows==1){


                    //   doctor dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='d';
                    header('location: doctor/index.php');

                }else{
                  // echo '<script>alert("Wrong credentials: Invalid email or password")</script>';
                  // $error='<div for="promter" class="input-field" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</div>';
                  $showAlert = true;
                  $alertMessage = "Wrong credentials: Invalid email or password";
                  
                }

            }
            
          }else{
            // echo'<div for="promter" class="input-field" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</div>';
            // echo '<script>alert("We cant found any acount for this email.")</script>';
            $showAlert = true;
            $alertMessage = "We can't find any account with this email.";
         
          }  
    }

    ?>
    
    <div class="container">
      <div class="forms-container">
        <div class="signin">
          <form action="#" method="POST" class="sign-in-form">
            <h2 class="title">Welcome Back</h2>

            <div class="input-field">
              <i class="fas fa-user"></i>
              <input
                type="email"
                name="useremail"
                placeholder="Email Address"
                required
              />
            </div>

            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input
                type="password"
                name="userpassword"
                placeholder="Password"
                required
              />
            </div>
            
            <div class="btn-inline">
              <button type="reset" value="Reset" name="sub">Reset</button>
              <button type="submit" value="Login">Log In</button>
            </div>
          </form>
          </div>
          <!-- alert msg -->
          <!-- <p style="text-align:center;color:red;"><b><?php echo '<script>alert</script>'  ?></b></p>-->
          <div id="alertMessage" class="alert hidden">
            <img class="alertimg" src="img/alert-img.png" alt="#">
            <h1>Oops</h1><br>
            <h3 id="alertText"></h3>
            <button onclick="closeAlert()">Close</button>
          </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h1>Don't have an account&#63;</h1>
            <p>
              First create your account, Enter your personal detail and start
              journey with us.
            </p>
            <div class="btn-inline">
              <a href="signup.php">
                <button class="btn transparent" id="sign-up-btn">Sign up</button>
              </a>
              <a href="index.html">
                <button class="btn transparent" id="sign-up-btn">Home</button>
              </a>
            </div>
          </div>
          <img src="img/log.svg" class="image" alt="#" />
        </div>
      </div>
    </div>
    <script>
         const showAlert = <?php echo json_encode($showAlert); ?>;
         const alertMessage = <?php echo json_encode($alertMessage); ?>;
        if (showAlert) {
            document.getElementById('alertMessage').classList.remove('hidden');
            document.getElementById('alertText').innerText = alertMessage;
        }
        function closeAlert() {
            document.getElementById('alertMessage').classList.add('hidden');
        }
    </script>
</body>
</html>