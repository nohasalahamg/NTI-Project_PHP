<?php

require './helpers/db.php';
require './helpers/functions.php';
require './helpers/checklogin.php';



require './layouts/header.php';
require './layouts/nav.php';
require './layouts/sidNav.php';



?>




<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area mr-1"></i>
                        Shippments
                    </div>
                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Users
                    </div>
                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
        <div class="row">
          <img src="../assets/1.jpeg" width="90%" height="50%"/>
        </div>
       
      
    </div>
</main>

<?php

require './layouts/footer.php';
?>