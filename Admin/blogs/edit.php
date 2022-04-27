<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

########################################################################################################
# Fetch Roles ..... 
$sql = "select * from roles";
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
    $name     = Clean($_POST['name']);
    $email    = Clean($_POST['email']);
    $role_id  = Clean($_POST['role_id']);
    $phone    = Clean($_POST['phone']);





    # Error [] 
    $errors = [];

    # Validate name ....  
    if (!validate($name, 'required')) {
        $errors['Name'] = "Field Required";
    } elseif (!validate($name, 'min', 3)) {
        $errors['Name'] = "Field Length must be >= 2 chars";
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
        $sql = "update  users   set name = '$name' , email = '$email' , phone = '$phone' , role_id = $role_id , image = '$FinalName' where id = $id";

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
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name"  value="<?php echo $Raw['name'];?>"  placeholder="Enter Name">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="email"  value="<?php echo $Raw['email'];?>"  placeholder="Enter email">
            </div>

            <!-- <div class="form-group">
                <label for="exampleInputPassword">New Password</label>
                <input type="password" class="form-control" required id="exampleInputPassword1" name="password" placeholder="Password">
            </div> -->



            <div class="form-group">
                <label for="exampleInputEmail">Phone</label>
                <input type="text" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="phone" value="<?php echo $Raw['phone'];?>" placeholder="Enter phone">
            </div>


            <div class="form-group">
                <label for="exampleInputPassword">Role</label>
                <select class="form-control" name="role_id">
                    <?php
                    while ($data = mysqli_fetch_assoc($roles_op)) {
                    ?>
                        <option value="<?php echo $data['id']; ?>"   <?php if($Raw['role_id'] == $data['id']) { echo 'selected';  }?>     ><?php echo $data['title']; ?></option>
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


	