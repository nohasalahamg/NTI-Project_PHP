<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';


########################################################################################################

$id = $_GET['id'];
# Fetch Raw Data .... 
$sql = "select blogs.* , category.title as cat_title , users.name from blogs inner join category on blogs.cat_id = category.id    
        inner join   users on blogs.addedBy = users.id  where blogs.id = $id ";
$op  = doQuery($sql);

if (mysqli_num_rows($op) == 0) {
    $message = ["Error" => 'Invalid Id'];
    $_SESSION['Message'] = $message;
    header("Location: index.php");
    exit;
} else {
    $data = mysqli_fetch_assoc($op);
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
            Messages('Dashboard / Users / Show');
            ?>


        </ol>


        <h3><?php echo $data['title'] ?></h3>
        <p>
            <?php echo $data['content'] ?>
            <br>
            <?php echo   date('Y-M-d', $data['pu_date']); ?>
            <br>

            <img src="./uploads/<?php echo $data['image']; ?>" alt="UserImage" height="400px" width="400px">
            <br>

            <?php echo $data['cat_title']; ?>
            <br>

            <?php echo $data['name']; ?>




        </p>





    </div>
</main>

<?php

require '../layouts/footer.php';
?>