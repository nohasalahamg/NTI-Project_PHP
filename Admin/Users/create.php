<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';


########################################################################################################
# Fetch Roles ..... 
$sql = "select * from role";
$roles_op = doQuery($sql);
########################################################################################################


// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    # FETCH && CLEAN DATA .... 
    $Fname     = Clean($_POST['Fname']);
    $Lname     = Clean($_POST['Lname']);
    $email    = Clean($_POST['email']);
    $address    = Clean($_POST['address']);
    $join_date    = date("Y-m-d");
    $password = Clean($_POST['password']);
    $role_id  = Clean($_POST['role_id']);
    $phone    = Clean($_POST['phone']);
   



    # Error [] 
    $errors = [];

    # Validate Firstname ....  
    if (!validate($Fname, 'required')) {
        $errors['Fname'] = "Field Required";
    } elseif (!validate($Fname, 'min', 3)) {
        $errors['Fname'] = "Field Length must be >= 2 chars";
    }
# Validate lastname ....
    if (!validate($Lname, 'required')) {
        $errors['Lname'] = "Field Required";
    } elseif (!validate($Lname, 'min', 3)) {
        $errors['Lname'] = "Field Length must be >= 2 chars";
    }

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

    # Validate role_id 
    if (!validate($role_id, 'required')) {
        $errors['Role'] = "Field Required";
    } elseif (!validate($role_id, 'int')) {
        $errors['Role'] = "Invalid Id";
    }


    # Validate phone 
    if (!validate($phone, 'required')) {
        $errors['phone'] = "Field Required";
    } elseif (!validate($phone, 'phone')) {
        $errors['phone'] = "InValid Format";
    }

      # Validate phone 
      if (!validate($address, 'required')) {
        $errors['address'] = "Field Required";
    } elseif (!validate($address, 'min',3)) {
        $errors['address'] = "InValid Format";
    }



    # Validate image 
    if (!validate($_FILES['image']['name'], 'required')) {
        $errors['Image'] = "Field Required";
    } elseif (!validate($_FILES, 'image')) {
        $errors['Image'] = "Invalid Format";
    }


    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE ..... 

        $typesInfo  =  explode('/', $_FILES['image']['type']);   // convert string to array ... 
        $extension  =  strtolower(end($typesInfo));      // get last element in array .... 

        # Create Final Name ... 
        $FinalName = uniqid() . '.' . $extension;

        $disPath = 'uploads/' . $FinalName;

        $temPath = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($temPath, $disPath)) {

            $password = md5($password);

            $sql = "insert into users (Fname,Lname,address,email,password,id_role,phone,image,Start_Join_date) values ('$Fname','$Lname','$address','$email','$password',$role_id,'$phone','$FinalName','$join_date')";
            $op  = doQuery($sql);

            if ($op) {
                $message = ["success" => "Raw Inserted"];
            } else {
                $message = ["Error" => "Try Again"];
            }
        } else {
            $message = ["Error" => "In Uploading try Again"];
        }
        $_SESSION['Message'] = $message;
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
            Messages('Dashboard / Users / Create');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">First Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="Fname" placeholder="Enter First Name">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Last Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="Lname" placeholder="Enter  Last Name">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">New Password</label>
                <input type="password" class="form-control" required id="exampleInputPassword1" name="password" placeholder="Password">
            </div>



            <div class="form-group">
                <label for="exampleInputEmail">Phone</label>
                <input type="number" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="phone" placeholder="Enter phone">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Address</label>
                <input type="text" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="address" placeholder="Enter Address">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">date</label>
                <input type="date" class="form-control"  required id="exampleInputEmail1" aria-describedby="emailHelp" name="join_date">
            </div>


            <div class="form-group">
                <label for="exampleInputPassword">Role</label>
                <select class="form-control" name="role_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($roles_op)) {
                    ?>
                        <option value="<?php echo $raw['id']; ?>"><?php echo $raw['role_name']; ?></option>
                    <?php } ?>
                </select>
            </div>


            <div class="form-group">
                <label for="exampleInputName">Image</label>
                <input type="file" name="image">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>