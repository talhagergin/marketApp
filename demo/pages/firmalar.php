<?php
session_start();
require_once "../helps.php";
include "../includes/db.php";


if(!isset($_SESSION["user_id"]))
{
  header("Location: ../pages/sign-in.php");
  exit();
}
if($_SESSION["user_role"]==0)
{
    header("Location: ../pages/dashboard.php");
    exit();
}


$loginUser=mysqli_query($connection,"SELECT * FROM users WHERE user_id = " . $_SESSION['user_id'])->fetch_assoc();

$breadcrumb = "Firmalar";

if(isset($_GET['comp_id'])){
  echo "stop";
  $the_company_id = $_GET['comp_id'];
  $company_info=mysqli_query($connection,"SELECT * FROM companies WHERE company_id = $the_company_id ")->fetch_all(MYSQLI_ASSOC);

}
else{
  $company_info=mysqli_query($connection,"SELECT * FROM companies")->fetch_all(MYSQLI_ASSOC);
}
//DELETE 
if(isset($_GET['delete'])){
  $the_company_id = $_GET['delete'];
  $query= "DELETE FROM companies WHERE company_id = $the_company_id";
  $delete_query=mysqli_query($connection,$query);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
      Firmalar
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-200">
  <?php include "../includes/sidebar.php"; ?>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include "../includes/navbar.php"; ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">             
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Firmalar</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                <div class="col-xs-3" style="margin-bottom:5px;margin-left:10px;">
                <a class="btn btn-success" href="../actions/add_company.php">Yeni Firma</a>
                </div>
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7">Firma Ad</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Adres</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Telefon</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Toplam Borç</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">İşlem Geçmişi</th>
                      <th class="text-secondary opacity-7 ps-1">İşlemler</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                   foreach($company_info as $company){
                    $the_company_id=$company["company_id"];
                    ?>                
                      <tr>                       
                      <td>                             
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?= $company["companyName"];?></h6>
                          </div>
                        </div>
                      </td>
                      <div class="d-flex flex-column justify-content-center">
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$company['companyAddress'];?></p>
                      </td> 
                      </div>  
                      <div class="d-flex flex-column justify-content-center">
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$company['companyPhone'];?></p>
                      </td> 

                      <div class="d-flex flex-column justify-content-center">
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$company['totalAmount'];?> ₺</p>
                      </td> 
                      </div>              
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><a href="../pages/projects.php?company_id=<?= $company['company_id'] ?>">İşlem Geçmişini Görüntüle</a></p>
                      </td>
                           
                      <td class="align-middle">
                        <button style="margin-right:5px; border-radius:5px;" title="Düzenle">
                       <a href="../actions/edit_company.php?company_id=<?= $company["company_id"]; ?>"><i class="fa fa-solid fa-pencil"></i></a>                     
                         <button style="margin-right:5px; border-radius:5px;" title="Sil">
                       <a onclick="javascript:return confirm('Firmayı silmek istediğinizden emin misiniz?');" href="firmalar.php?delete=<?= $company["company_id"]; ?>"><i class="fa fa-solid fa-trash"></i></a>
                        </button>
                        </button>
                      </td>                                         
                    </tr>
                   <?php  } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
        </div>
      </div>
    </div>
  </main>
  <?php include "../includes/navbar_settings.php"; ?>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.0.4"></script>
  <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  <script>
    $('#menu-firmalar').addClass('active bg-gradient-primary');
  </script>
</body>

</html>