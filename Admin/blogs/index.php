<?php

########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

# Fetch Data 
$sql = "select blogs.* , category.title as cat_title , users.name from blogs inner join category on blogs.cat_id = category.id    
        inner join   users on blogs.addedBy = users.id ";
$op  = doQuery($sql);
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
            Messages('Dashboard / Blogs / Display');
            ?>

        </ol>



        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Blogs Data
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>AddedBy</th>
                                <th>Details</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                               <th>ID</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>AddedBy</th>
                                <th>Details</th>
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
                                    <td><?php echo  substr($raw['content'],0,49); ?></td>
                                    <td><?php echo   date('Y-M-d',$raw['pu_date']); ?></td>
                                    <td> <img src="./uploads/<?php echo $raw['image']; ?>" alt="UserImage"  height="70px"  width="70px">  </td>
                                    <td><?php echo $raw['cat_title']; ?></td>
                                    <td><?php echo $raw['name']; ?></td>
                                
                                     <td><a href='show.php?id=<?php echo $raw['id']; ?>' class='btn btn-primary m-r-1em'>Show</a>
</td>
                                  
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