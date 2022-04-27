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

    $sql = "delete from role where id = $id"; 

    $op = doQuery($sql); 

    if($op){
        $message = ["Success" => "Role  Removed"];
    }else{
        $message = ["Error" => "Error Try Again Please"];
    }

}

# Set Session ... 
$_SESSION['Message'] = $message; 

header("Location: index.php"); 




?>