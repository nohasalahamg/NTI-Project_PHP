<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

$id = $_GET['id'];
# Fetch Raw Data .... 
$sql = "select * from company_tax where id = $id";
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
$sql_user="select company_tax.* , users.id as iduser ,users.Fname from company_tax inner join users on company_tax.user_id = users.id";   

//$sql_user = "select * from users";
$user_op  = doQuery($sql_user);

$data = mysqli_fetch_assoc($user_op);

########################################################################################################






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
        $sql = "update  company_tax  set tax_id = '$tax_id' , user_id='$user_id' where id = $id";
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

        <div class="form-group">
                <label for="exampleInputName">Tax ID </label>
                <input type="number" class="form-control" required id="exampleInputName" aria-describedby="" name="tax_id" placeholder="Enter Role Name" value="<?php echo $raw['tax_id'];?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">User</label>
                <select class="form-control" name="user_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($user_op)) {
                    ?>
                        <option value="<?php echo $raw['user_id']; ?>" <?php if($raw['user_id'] == $data['iduser']) { echo 'selected';  }?>  ><?php echo $data['Fname']; ?></option>
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


	