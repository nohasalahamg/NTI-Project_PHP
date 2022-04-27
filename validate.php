<?php

class validate{

    function check($input, $flag,$length = 6)
    {
    
        $status = true;
    
        switch ($flag) {
            case 'required':
                # code...
                if (empty($input)) {
                    $status = false;
                }
                break;
    
            case 'email':
                # code ... 
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $status = false;
                }
                break;
    
            case 'int':
                # code ... 
                if (!filter_var($input, FILTER_VALIDATE_INT)) {
                    $status = false;
                }
                break;
    
        }
    
        return $status;
    }

}




$vaild = new validate();
$name="PHP";
$vaild->check($name,"required");
if ($vaild->check($name,"required")){
    echo     "Data Vaild not empty " .$vaild->check($name,"required");
}else
{

    echo     "Data Not  Vaild  empty" .$vaild->check($name,"required");
}

?>

