<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';


$sql = "select * from users";
$users_op = doQuery($sql);

// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    # FETCH && CLEAN DATA .... 
    $user_id= Clean($_POST['user_id']);
    $tax_id= Clean($_POST['tax_id']);


    

    # Validate user_id 
    if (!validate($user_id, 'required')) {
        $errors['user_id'] = "Field Required";
    } elseif (!validate($user_id, 'int')) {
        $errors['user_id'] = "Invalid  UserID";
    }


        # Validate tax_id 
        if (!validate($tax_id, 'required')) {
            $errors['tax_id'] = " Tax ID Field Required";
        } elseif (!validate($tax_id, 'int')) {
            $errors['tax_id'] = "Invalid Tax ID";
        }
    

    # Error [] 
    $errors = [];

    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE ..... 


        $check=$_SESSION["user"]["id"];
$check_role =$_SESSION["user"]["id_role"];

if($check_role== 6 or $check_role== 2){
    $sql = "insert into company_tax (tax_id,user_id) values ('$tax_id',$check)";
}else{
    $sql = "insert into company_tax (tax_id,user_id) values ('$tax_id',$user_id)";
}


     
        $op  = doQuery($sql);

        if ($op) {
            $message = ["success" => "Role Inserted SuccessFul"];
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
            Messages('Dashboard / Company Tax / Create');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Tax ID </label>
                <input type="number" class="form-control" required id="exampleInputName" aria-describedby="" name="tax_id" placeholder="Enter Role Name">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">User</label>
                <select class="form-control" name="user_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($users_op)) {
                    ?>
                        <option value="<?php echo $raw['id']; ?>"><?php echo $raw['Fname']; ?></option>
                    <?php } ?>
                </select>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>