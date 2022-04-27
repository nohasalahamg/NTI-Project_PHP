    
 
        
        <div id="layoutSidenav">
       <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Express Delivery
                            </a>
                           
                            <div class="sb-sidenav-menu-heading">Express Delivery</div>
                           
                            <?php //admin
                              //$modules = ["Roles", "Users" ,"shipments","Company_Tax","Status","Users&&Shippments"];
                            
                            if($_SESSION["user"]["id_role"]== 1){
                                $modules = ["Roles", "Users" ,"shipments","Company_Tax","Status","Users&&Shippments"];
                            

                            }//Employee
                              elseif($_SESSION["user"]["id_role"]== 5){
                                $modules = [ "shipments","Company_Tax","Status","Users&&Shippments"];
                            
                              }
                            
//Company
elseif($_SESSION["user"]["id_role"]== 2){
    $modules = [ "shipments","Company_Tax"];

  }
  //courier

  elseif($_SESSION["user"]["id_role"]== 6){
    $modules = [ "shipments"];

  }
 
                                foreach ($modules as $key => $value) {
                                    # code..

                            ?>



                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts<?php echo $key?>" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                              <?php   echo $value; ?>
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts<?php echo $key?>" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <?php if($value != "Status" and $value!= "Users&&Shippments") {?>
                                    <a class="nav-link" href="<?php echo url($value.'/create.php')?>">+ Create</a>
                                    <?php }?>
                                    <a class="nav-link" href="<?php echo url($value.'/')?>">Show</a>
                                </nav>
                            </div>
                            <?php } ?>
                            
                            
                            
                            
              
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">:</div>
                        Delivery Express
                    </div>
                </nav>
            </div>


            <div id="layoutSidenav_content">