<?php

########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

# Fetch Data 
$check=$_SESSION["user"]["id"];
$check_role =$_SESSION["user"]["id_role"];

// if($check_role== 6 or $check_role== 2){
//     $sql = "select * from company_tax  where user_id=$check";
// }else{
    $sql = "select * from company_tax";


$op  = doQuery($sql);
########################################################################################################

# Fetch Raw Data .... 
$sql_user="select company_tax.* , users.* from company_tax inner join users on company_tax.user_id = users.id";   

//$sql_user = "select * from users";
$user_op  = doQuery($sql_user);

$raw1 = mysqli_fetch_assoc($user_op);
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
                                <th>Tax ID</th>

                                <th>First Name</th>  
                                <th>Last Name</th>  
                                <th>Email</th>  




                                                              <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tax IDe</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
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
                                    <td><?php echo $raw['tax_id']; ?></td>
                                    <td><?php echo $raw1['Fname']; ?></td>
                                    <td><?php echo $raw1['Lname']; ?></td>
                                    <td><?php echo $raw1['Email']; ?></td>
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