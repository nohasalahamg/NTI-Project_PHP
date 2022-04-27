<?php

########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

# Fetch Data 

$check=$_SESSION["user"]["id"];
$check_role =$_SESSION["user"]["id_role"];

//$sql = "select users.* , role.role_name from users inner join role on users.id_role = role.id";
if( $check_role!= 1){
    
$sql = "select users.* , role.role_name from users inner join role on users.id_role = role.id where users.id=$check";
}else{
   
$sql = "select users.* , role.role_name from users inner join role on users.id_role = role.id";
}


$op  = doQuery($sql);
########################################################################################################




require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';

?>

<main><?php
echo $check_role;?>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
           
        
        <?php
            # Print Messages .... 
            Messages('Dashboard / Roles / Display');
            ?>

        </ol>









        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Roles Data
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>FirstName</th>
                                <th>LastName</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Image</th>
                                <th>Address</th>
                                <th>Start Join</th>
                                <th>Role Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <th>ID</th>
                                <th>FirstName</th>
                                <th>LastName</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Image</th>
                                <th>Address</th>
                                <th>Start Join</th>
                                <th>Role Type</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>


                            <?php
                            # LOOP .... 
                            $i = 0;
                            while ($raw = mysqli_fetch_assoc($op)) {
                            ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                    <td><?php echo $raw['Fname']; ?></td>
                                    <td><?php echo $raw['Lname']; ?></td>
                                    <td><?php echo $raw['Email']; ?></td>
                                    <td><?php echo $raw['phone']; ?></td>
                                    
                                    <td> <img src="./uploads/<?php echo $raw['image']; ?>" alt="UserImage"  height="70px"  width="70px">  </td>
                                    <td><?php echo $raw['address']; ?></td>
                                    <td><?php echo $raw['Start_join_date']; ?></td>
                                    <td><?php echo $raw['role_name']; ?></td>
                                    
                                    <td>

                                        <a href='delete.php?id=<?php echo $raw['id']; ?>' class='btn btn-danger m-r-1em'>Delete</a>

                                        <a href='edit.php?id=<?php echo $raw['id']; ?>' class='btn btn-primary m-r-1em'>Edit</a>
                                    </td>

                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php

require '../layouts/footer.php';
?>