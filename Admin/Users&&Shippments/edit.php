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



$sql_user="select * from  users ";   

;
$user_op  = doQuery($sql_user);

$data = mysqli_fetch_assoc($user_op);

########################################################################################################




// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {


  # FETCH && CLEAN DATA .... 

$user_id= Clean($_POST['user_id']);
    
    # Error [] 
    $errors = [];


    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE .....
        
        $sql="UPDATE `shippment` SET `user_id`=$user_id WHERE `id`=$id";

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
                <label for="exampleInputName">change User </label>
                <div class="form-group">
                <label for="exampleInputPassword">User </label>
                <select class="form-control" name="user_id">
                    <?php
                    while ($data = mysqli_fetch_assoc($user_op)) {
                    ?>
                        <option value="<?php echo $data['id']; ?>"   <?php if($raw['user_id'] == $data['id']) { echo 'selected';  }?>     ><?php echo $data['Fname']; ?></option>
                    <?php } ?>
                </select>
            </div>

        

</div>
      

     
        
        
        
        
        
        </div>
    <div class="col">



    </div>
</div>
      



            <button type="submit" class="btn btn-primary">Update User</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>


	