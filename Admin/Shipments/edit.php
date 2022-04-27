<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

$id = $_GET['id'];
# Fetch Raw Data .... 
$sql = "select * from shippment where id = $id";
$op  = doQuery($sql);



if (mysqli_num_rows($op) == 0) {
    $message = ["Error" => 'Invalid Id'];
    $_SESSION['Message'] = $message;
    header("Location: index.php");
    exit;
} else {
    $raw = mysqli_fetch_assoc($op);
}



# Fetch Raw Data .... 
$sql_user="select shippment.* , users.* from shippment inner join users on shippment.user_id = users.id";   

//$sql_user = "select * from users";
$user_op  = doQuery($sql_user);

$data = mysqli_fetch_assoc($user_op);

########################################################################################################






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

    
    # Error [] 
    $errors = [];


    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE .....
        
        $sql=
        "UPDATE `shippment` SET `title`='$title',`details`='$details',`location`='$location',
   `name_customer`='$name_customer',`phone_customer`='$phone_customer',
   `start_date`='$start_date',`pickup_date`='$pickup_date',`payment`='$payment' WHERE `id`=$id";

        $op  = doQuery($sql);

        if ($op) {
            $message = ["success" => "Role Updated"];
           
            $_SESSION['Message'] = $message;
           
            header("Location: index.php");

            exit;

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
            Messages('Dashboard / Roles / Edit');
            ?>


        </ol>


        <form action="edit.php?id=<?php  echo $raw['id'];?>" method="post" enctype="multipart/form-data">

        <div class="row">
      <div class="col"> 
         <div class="form-group">
                <label for="exampleInputName">Title </label>
                <input type="text"  value="<?php echo $raw['title']; ?>"class="form-control" required id="exampleInputName" aria-describedby="" name="title" placeholder="Enter title">
            </div>
        
            <div class="form-group">
                <label for="exampleInputName">Details For Shipment</label>
                <textarea type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="details" placeholder="Enter Details"><?php echo $raw['details']; ?></textarea>
</div>
            <div class="form-group">
                <label for="exampleInputName">Location </label>
                <input type="text" class="form-control"  value="<?php echo $raw['location'];?>" required id="exampleInputName" aria-describedby="" name="location" placeholder="Enter Destination">
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
                <input type="text"  value="<?php echo $raw['name_customer']; ?>" class="form-control" required id="exampleInputName" aria-describedby="" name="name_customer" placeholder="Enter title">
            </div>

    <div class="form-group">
                <label for="exampleInputName">Phone Customer </label>
                <input type="number"    value="<?php echo $raw['phone_customer']; ?>" class="form-control" required id="exampleInputName" aria-describedby="" name="phone_customer" placeholder="Enter Phone">
            </div>

 <div class="form-check form-check-inline">
        
  <input class="form-check-input" type="radio" name="payment" id="inlineRadio1"  value="Cash"<?php if($raw['payment']=='Cash'){?>checked<?php }?>>
  <label class="form-check-label" for="inlineRadio1">Cash</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="payment" id="inlineRadio2" value="Credit Card" <?php if($raw['payment']=='Credit Card'){?>checked<?php }?>>
  <label class="form-check-label" for="inlineRadio2">Credit Card</label>
</div>


<div class="form-group">
                <label for="exampleInputEmail">Start Date</label>
                <input type="date"  value="<?php  echo $raw['start_date'];?>"class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="start_date">
            </div>


            
            <div class="form-group">
                <label for="exampleInputEmail"> Pick Up Date</label>
                <input type="date"  value="<?php  echo $raw['pickup_date'];?>"class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="pickup_date">
            </div>


    </div>
</div>
      



            <button type="submit" class="btn btn-primary">Update</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>


	