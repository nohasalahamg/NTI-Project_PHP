<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';


$sql = "select * from users";
$users_op = doQuery($sql);

// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    # FETCH && CLEAN DATA .... 
    $title= Clean($_POST['title']);
    $details= Clean($_POST['details']);

    $location= Clean($_POST['location']);
    //$status= Clean($_POST['status']);

    $name_customer= Clean($_POST['name_customer']);
    $phone_customer= Clean($_POST['phone_customer']);

    $start_date= Clean($_POST['start_date']);
    $pickup_date= Clean($_POST['pickup_date']);

    //$user_id= Clean($_POST['user_id']);
    $payment= Clean($_POST['payment']);

//title
    if (!validate($title, 'required')) {
        $errors['title'] = "Field Required";
    } elseif (!validate($title, 'min', 3)) {
        $errors['title'] = "Field Length must be >= 2 chars";
    }
# Validate details ....
    if (!validate($details, 'required')) {
        $errors['details'] = "Field Required";
    } elseif (!validate($details, 'min', 3)) {
        $errors['details'] = "Field Length must be >= 2 chars";
    }





    if (!validate($location, 'required')) {
        $errors['location'] = "Field Required";
    } elseif (!validate($location, 'min', 3)) {
        $errors['location'] = "Field Length must be >= 2 chars";
    }
# Validate lastname ....
    // if (!validate($status, 'required')) {
    //     $errors['status'] = "Field Required";
    // } elseif (!validate($status, 'min', 3)) {
    //     $errors['status'] = "Field Length must be >= 2 chars";
    // }




    if (!validate($name_customer, 'required')) {
        $errors['name_customer'] = "Field Required";
    } elseif (!validate($name_customer, 'min', 3)) {
        $errors['name_customer'] = "Field Length must be >= 2 chars";
    }
    if (!validate($phone_customer, 'required')) {
        $errors['phone_customer'] = "Field Required";
    } elseif (!validate($phone_customer, 'phone')) {
        $errors['phone_customer'] = "InValid Format";
    }




    # Validate date 
    if (!validate($start_date, 'required')) {
        $errors['start_date'] = "Field Required";
    } elseif (!validate($start_date, 'date')) {
        $errors['start_date'] = "InValid Format";
    } elseif (!validate($start_date, 'DateNext')) {
        $errors['start_date'] = "InValid Date";
    }

    # Validate date 
    if (!validate($pickup_date, 'required')) {
        $errors['pickup_date'] = "Field Required";
    } elseif (!validate($pickup_date, 'date')) {
        $errors['pickup_date'] = "InValid Format";
    } elseif (!validate($pickup_date, 'DateNext')) {
        $errors['pickup_date'] = "InValid Date";
    }








    if (!validate($payment, 'required')) {
        $errors['payment'] = "Field Required";
    } elseif (!validate($payment, 'min', 3)) {
        $errors['payment'] = "Field Length must be >= 2 chars";
    }


    // # Validate user_id 
    // if (!validate($user_id, 'required')) {
    //     $errors['user_id'] = "Field Required";
    // } elseif (!validate($user_id, 'int')) {
    //     $errors['user_id'] = "Invalid  UserID";
    // }

    $check=$_SESSION["user"]["id"];

    

    # Error [] 
    $errors = [];

    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE ..... 

        $sql = "insert into shippment (`title`, `details`, `location`, `status`, `name_customer`,`phone_customer`, `start_date`, `pickup_date`, `user_id`, `payment`) values ('$title','$details','$location','Pendding','$name_customer','$phone_customer','$start_date','$pickup_date',$check,'$payment')";
        $op  = doQuery($sql);

        if ($op) {
            $message = ["success" => "shipment Inserted SuccessFul"];
        } else {
            $message = ["Error" => "Try Again Please"];
        }

        $_SESSION['Message'] = $message;
        header("Location: index.php"); 
    }
}
########################################################################################################



require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';

?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">


            <?php
            # Print Messages .... 
            Messages('Dashboard / Shippment / Create');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <div class="row">
      <div class="col"> 
         <div class="form-group">
                <label for="exampleInputName">Title </label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" placeholder="Enter title">
            </div>
        
            <div class="form-group">
                <label for="exampleInputName">Details For Shipment</label>
                <textarea type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="details" placeholder="Enter Details"></textarea>
</div>
            <div class="form-group">
                <label for="exampleInputName">Location </label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="location" placeholder="Enter Destination">
            </div>
            <div class="form-group">
                <label for="exampleInputName">Status :</label>
                Pendding
                <div class="progress">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
</div>
            </div>

     
        
        
        
        
        
        </div>
    <div class="col">
    <div class="form-group">
                <label for="exampleInputName">Name Customer </label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name_customer" placeholder="Enter title">
            </div>

    <div class="form-group">
                <label for="exampleInputName">Phone Customer </label>
                <input type="number" class="form-control" required id="exampleInputName" aria-describedby="" name="phone_customer" placeholder="Enter Phone">
            </div>

            <div class="form-check form-check-inline">
        
  <input class="form-check-input" type="radio" name="payment" id="inlineRadio1" value="Cash">
  <label class="form-check-label" for="inlineRadio1">Cash</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="payment" id="inlineRadio2" value="Credit Card">
  <label class="form-check-label" for="inlineRadio2">Credit Card</label>
</div>


<div class="form-group">
                <label for="exampleInputEmail">Start Date</label>
                <input type="date" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="start_date">
            </div>


            
            <div class="form-group">
                <label for="exampleInputEmail"> Pick Up Date</label>
                <input type="date" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="pickup_date">
            </div>


    </div>
</div>
      
           


         


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>