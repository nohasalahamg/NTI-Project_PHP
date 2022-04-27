<?php  
  
  require './helpers/db.php';
  require './helpers/functions.php';


   if($_SERVER['REQUEST_METHOD'] == "POST"){

     // CODE ..... 

     # FETCH && CLEAN DATA .... 
    $email    = Clean($_POST['email']);
    $password = Clean($_POST['password']);

    # Error [] 
    $errors = [];


    # Validate Password 
    if (!validate($password, 'required')) {
        $errors['Password'] = "Field Required";
    } elseif (!validate($password, 'min')) {
        $errors['Password'] = "Field Length must be >= 6 chars";
    }


    # Validate Email 
    if (!validate($email, 'required')) {
        $errors['Email'] = "Field Required";
    } elseif (!validate($email, 'email')) {
        $errors['Email'] = "Invalid Format";
    }


     if(count($errors) > 0 ){
        
        $_SESSION['Message'] = $errors;
     }else{

      // login ..... 
      $password = md5($password); 
      $sql = "select * from users where email = '$email' && password = '$password'"; 

      $op  = doQuery($sql); 

      if(mysqli_num_rows($op) == 1){
        // code.... 
     
        $data = mysqli_fetch_assoc($op); 

        $_SESSION['user'] = $data; 

        header("location: ".url(''));


      }else{
        $_SESSION['Message'] = ["Error" => "Invalid Email || Password"];
      }

     }





   }


?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Express Delivery</title>
        <style>
.x{
    background-image: url('../assets/5.jpg');
    background-repeat: no-repeat;
    background-size: cover;
}

        </style>

        <link href="./resources/css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-default x" >
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main class="x">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4"><img src="../assets/logo2.png" width="20%" height="20%"/></h3></div>
                                    <div class="card-body">
                                        
                                     <?php 
                                        
                                         Messages();
                                     
                                     ?>


                                    
                                    <form   action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method= "post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" id="inputEmailAddress" type="email" placeholder="Enter email address"  name="email" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password"  name="password" />
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                   <a href="<?php echo  Base_url('');?>">Back To Home</a>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <!-- <a class="small" href="password.html">Forgot Password?</a> -->
                                                <input type="submit" class="btn btn-primary" value="Login">
                                            </div>
                                        </form>



                                    </div>
                                    <!-- <div class="card-footer text-center">
                                        <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; NA</div>
                            <div>
                               
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="./resources/js/scripts.js"></script>
    </body>
</html>
