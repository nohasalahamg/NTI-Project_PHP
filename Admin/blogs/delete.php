<?php 
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

# Fetch Id .... 
$id = $_GET['id']; 

# Validate Id .... 

if(!validate($id,'int')){
    $message = ["Error" => "Invalid Id"];
}else{
    # Fetch image name .... 
    $sql  = "select image from blogs where id = $id"; 
    $op   = doQuery($sql); 
    $data =  mysqli_fetch_assoc($op); 


    $sql = "delete from blogs where id = $id"; 

    $op = doQuery($sql); 

    if($op){

        removeFile( $data['image']);
        $message = ["Success" => "Raw Removed"];
    }else{
        $message = ["Error" => "Error Try Again"];
    }

}

# Set Session ... 
$_SESSION['Message'] = $message; 

header("Location: index.php");
