<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

########################################################################################################
# Fetch Roles ..... 
$sql = "select * from role";
$roles_op = doQuery($sql);
########################################################################################################

$id = $_GET['id'];
# Fetch Raw Data .... 
$sql = "select * from users where id = $id";
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
    $Fname     = Clean($_POST['Fname']);
    $Lname     = Clean($_POST['Lname']);
    $email    = Clean($_POST['email']);
    $address    = Clean($_POST['address']);
  
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
      if (!validate($address, 'required')) {
        $errors['address'] = "Field Required";
    } elseif (!validate($address, 'min',3)) {
        $errors['address'] = "InValid Format";
    }


    # Validate phone 
    if (!validate($phone, 'required')) {
        $errors['phone'] = "Field Required";
    } elseif (!validate($phone, 'phone')) {
        $errors['phone'] = "InValid Format";
    }



    # Validate image 
    if (validate($_FILES['image']['name'], 'required')) {

        if (!validate($_FILES, 'image')) {
            $errors['Image'] = "Invalid Format";
        }
    }




    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {



        if (validate($_FILES['image']['name'], 'required')) {

            $typesInfo  =  explode('/', $_FILES['image']['type']);   // convert string to array ... 
            $extension  =  strtolower(end($typesInfo));      // get last element in array .... 
    
            # Create Final Name ... 
            $FinalName = uniqid() . '.' . $extension;
    
            $disPath = 'uploads/' . $FinalName;
    
            $temPath = $_FILES['image']['tmp_name'];
    
            if (move_uploaded_file($temPath, $disPath)) {
                unlink('uploads/'.$Raw['image']);
            }
        }else{
            $FinalName = $Raw['image'];
        }


        # DB CODE ..... 
        $sql = "update  users   set Lname='$Lname', Fname = '$Fname' , Email = '$email' , phone = '$phone' ,address='$address' ,id_role = $role_id , image = '$FinalName' where id = $id";

        $op  = doQuery($sql);

        if ($op) {
            $message = ["success" => "Raw Updated"];
           
            $_SESSION['Message'] = $message;
           
            header("Location: index.php");

            exit;

        } else {
            $message = ["Error" => "Try Again"];
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
            Messages('Dashboard / Users / Edit');
            ?>


        </ol>


        <form action="edit.php?id=<?php  echo $Raw['id'];?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
                <label for="exampleInputName">First Name</label>
                <input type="text" class="form-control" required  value="<?php echo $Raw['Fname'];?>" id="exampleInputName" aria-describedby="" name="Fname" placeholder="Enter First Name">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Last Name</label>
                <input type="text" class="form-control" required value="<?php echo $Raw['Lname'];?>"  id="exampleInputName" aria-describedby="" name="Lname" placeholder="Enter  Last Name">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" value="<?php echo $Raw['Email'];?>"  required id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
            </div>

         

          
            <div class="form-group">
                <label for="exampleInputEmail">Phone</label>
                <input type="text" class="form-control" required  value="<?php echo $Raw['phone'];?>" id="exampleInputEmail1" aria-describedby="emailHelp" name="phone" placeholder="Enter phone">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail">Address</label>
                <input type="text" class="form-control" required  value="<?php echo $Raw['address'];?>" id="exampleInputEmail1" aria-describedby="emailHelp" name="address" placeholder="Enter Address">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Role</label>
                <select class="form-control" name="role_id">
                    <?php
                    while ($data = mysqli_fetch_assoc($roles_op)) {
                    ?>
                        <option value="<?php echo $data['id']; ?>"   <?php if($Raw['id_role'] == $data['id']) { echo 'selected';  }?>     ><?php echo $data['role_name']; ?></option>
                    <?php } ?>
                </select>
            </div>


            <div class="form-group">
                <label for="exampleInputName">Image</label>
                <input type="file" name="image">
            </div>
            
            <img src="./uploads/<?php echo $Raw['image']; ?>" alt="UserImage"  height="70px"  width="70px"> 
            <br>


            <button type="submit" class="btn btn-primary">Edit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>


	