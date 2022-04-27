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
  $status= Clean($_POST['status']);
  

echo $status;


    
    # Error [] 
    $errors = [];


    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE .....
        
        $sql="UPDATE `shippment` SET `status`='$status' WHERE `id`=$id";

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
            Messages('Dashboard / Status/ Edit');
            ?>


        </ol>


        <form action="edit.php?id=<?php  echo $raw['id'];?>" method="post" enctype="multipart/form-data">

        <div class="row">
      <div class="col"> 
  
            <div class="form-group">
                <label for="exampleInputName">Status :</label>
                <div class="form-check form-check-inline">
        
        <input class="form-check-input" type="radio" name="status" id="inlineRadio1"  value="Pendding" <?php if($raw['status']=='Pendding'){?>checked<?php }?>>
        <label class="form-check-label" for="inlineRadio1">Pendding</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="PickUp" <?php if($raw['status']=='PickUp'){?>checked<?php }?>>
        <label class="form-check-label" for="inlineRadio2">PickUp</label>
      </div>

      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="inlineRadio3" value="Progress" <?php if($raw['status']=='Progress'){?>checked<?php }?>>
        <label class="form-check-label" for="inlineRadio3">Progress</label>
      </div>

      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status" id="inlineRadio4" value="Done" <?php if($raw['status']=='Done'){?>checked<?php }?>>
        <label class="form-check-label" for="inlineRadio4">Done</label>
      </div>


</div>
      

     
        
        
        
        
        
        </div>
    <div class="col">



    </div>
</div>
      



            <button type="submit" class="btn btn-primary">Update statuss</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>


	