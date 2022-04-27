<?php

########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';


########################################################################################################

# Fetch Raw Data .... 
// $sql_user="select company_tax.* , users.* from company_tax inner join users on company_tax.user_id = users.id where users.id= $_SESSION['user']['id']";   
                            
// //Company
// if($_SESSION["user"]["id_role"]== 2){
//     $sql_user="shippment.* , users.* from shippment inner join users on shippment.user_id = users.id where users.id= ";   

//   }
//   //courier
//   elseif($_SESSION["user"]["id"]== 5){
//     $sql = "select * from shippment";

//   }
  # Fetch Data 
  $check=$_SESSION["user"]["id"];
$check_role =$_SESSION["user"]["id_role"];

if($check_role== 6 or $check_role== 2){
    $sql = "Select shippment.* , users.* from shippment inner join users on shippment.user_id = users.id where users.id=$check";
}else{
    $sql = "Select * from shippment ";
}

$op  = doQuery($sql);
$sql_user = "select * from users";
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
               <?php echo $check_role;?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>

                                <th>Start Date</th>  
                                <th>Pick Up Date</th>  
                                <th>Location</th>  
                                <th>Status</th> 



                                                              <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>

<th>Start Date</th>  
<th>Pick Up Date</th>  
<th>Location</th>  
<th>Status</th> 
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
                                    <td><?php echo $raw['title']; ?></td>
                                    <td><?php echo $raw['start_date']; ?></td>
                                    <td><?php echo $raw['pickup_date']; ?></td>
                                    <td><?php echo $raw['location']; ?></td>
                                    <td><?php
                                    
                                    if($raw['status']=="Pendding"){?>
                  <span class="btn btn-info">Pendding</span>                 
                                                  <?php
                                    }
                                     elseif($raw['status']=="PickUp")

                                    {?>
                                        <span class="btn btn-warning">PickUP</span>
                                    <?php }
                                    elseif($raw['status']=="Progress")

                                    {?>
                                        <span class="btn btn-danger">Progress</span>
                                        <?php }

                                        

                                
                                    elseif($raw['status']=="Done"){

?><span class="btn btn-success">Done</span>

<?php

                                    }
?>

                                   </td>
                                    <td>
                                    <a href='show.php?id=<?php echo $raw['id']; ?>' class='btn btn-info m-r-1em'>Show</a>

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