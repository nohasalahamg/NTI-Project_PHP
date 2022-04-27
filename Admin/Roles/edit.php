<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

$id = $_GET['id'];
# Fetch Raw Data .... 
$sql = "select * from role where id = $id";
$op  = doQuery($sql);

if (mysqli_num_rows($op) == 0) {
    $message = ["Error" => 'Invalid Id'];
    $_SESSION['Message'] = $message;
    header("Location: index.php");
    exit;
} else {
    $Raw = mysqli_fetch_assoc($op);
}
########################################################################################################






// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    # FETCH && CLEAN DATA .... 
    $role_name = Clean($_POST['role_name']);

    # Error [] 
    $errors = [];

    # Validate title ....  
    if (!validate($role_name, 'required')) {
        $errors['role_name'] = "Field Required";
    } elseif (!validate($role_name, 'min', 3)) {
        $errors['role_name'] = "Field Length must be >= 3 chars";
    }

    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE ..... 
        $sql = "update  role  set role_name = '$role_name' where id = $id";
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


        <form action="edit.php?id=<?php  echo $Raw['id'];?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Role Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="role_name" value="<?php echo $Raw['role_name'];?>" placeholder="Enter Role Name">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>


	