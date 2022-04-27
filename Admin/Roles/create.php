<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';


// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    # FETCH && CLEAN DATA .... 
    $role_name = Clean($_POST['role_name']);

    # Error [] 
    $errors = [];

    # Validate  Role Name ....  
    if (!validate($role_name, 'required')) {
        $errors['role_name'] = "Role Name Required";
    } elseif (!validate($role_name, 'min', 3)) {
        $errors['role_name'] = "Field Length must be >= 3 chars";
    }

    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE ..... 

        $sql = "insert into role (role_name) values ('$role_name')";
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
            Messages('Dashboard / Roles / Create');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Role Name </label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="role_name" placeholder="Enter Role Name">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>