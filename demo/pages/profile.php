<?php
session_start();
require_once "../helps.php";
include "../includes/db.php";


if(!isset($_SESSION["user_id"]))
{
  header("Location: ../pages/sign-in.php");
  exit();
}

$loginUser=mysqli_query($connection,"SELECT * FROM users WHERE user_id = " . $_SESSION['user_id'])->fetch_assoc();


$breadcrumb = "Profil";

if(isset($_GET['user_id']))
{
    $the_user_id = $_GET['user_id'];
    if ($the_user_id == $_SESSION['user_id'])
    {
        $query = "SELECT * FROM users WHERE user_id = $the_user_id";
        $select_user = mysqli_query($connection, $query)->fetch_assoc();
    }
    else{
        if($_SESSION['user_role']==0) {
            header('Location: ../pages/dashboard.php');
            exit();
        }
        else{
            $query = "SELECT * FROM users WHERE user_id = $the_user_id";
            $select_user = mysqli_query($connection, $query)->fetch_assoc();
        }
    }
}
else{
  $the_user_id=$_SESSION["user_id"];
  $query="SELECT * FROM users WHERE user_id = $the_user_id";
  $select_user=mysqli_query($connection,$query)->fetch_assoc();
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
    KayraSoft | Profil
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
  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    <?php include "../includes/navbar.php"; ?>
    <!-- End Navbar -->
    <div class="container-fluid px-2 px-md-4">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <span class="mask  bg-gradient-primary  opacity-6"></span>
      </div>
      <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4 mb-2">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="../assets/img/user_image/<?=$select_user["user_image"];?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?= $select_user['username'];?>
              </h5>
              <p class="mb-0 font-weight-normal text-sm">
                <?php 
                if($select_user['user_role']==0){
                  echo "Personel";
                }
                else{
                  echo "Admin";
                }
                ?>
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                <a href="../pages/profile.php"><button class="btn btn-dark">Profil</button></a>               
                </li>
                <li class="nav-item">
                <a href="../pages/projects.php?personal_id=<?= $the_user_id;?>"><button class="btn btn-dark">Projeler</button></a>               
                </li>
                <li class="nav-item">
                <a href="../actions/edit_user.php?user_id=<?=$the_user_id;?>"><button class="btn btn-dark">Ayarlar</button></a>               
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="row">
            <div class="col-6 col-xl-8">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      <h6 class="mb-0">Personel Bilgileri</h6>
                    </div>
<!--                    <div class="col-md-4 text-end">-->
<!--                      <a href="javascript:;">-->
<!--                        <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Profil Düzenle"></i>-->
<!--                      </a>-->
<!--                    </div>-->
                  </div>
                </div>
                <div class="card-body p-3">
                  <hr class="horizontal gray-light my-2">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-l"><strong class="text-dark">Ad Soyad:</strong> &nbsp; <?=$select_user["user_firstname"]." ".$select_user["user_lastname"];?></li>
                    <li class="list-group-item border-0 ps-0 text-l"><strong class="text-dark">Telefon:</strong> &nbsp; <?=$select_user["user_phone"];?></li>
                    <li class="list-group-item border-0 ps-0 text-l"><strong class="text-dark">Email:</strong> &nbsp; <?=$select_user["user_email"];?></li>
                    
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <h6 class="mb-0">Devam Eden Projeler</h6>
                </div>
                <div class="card-body p-3">
                  <ul class="list-group">
                  <?php 
                  //Get project where user id 
                  $query="SELECT * FROM projects WHERE user_id LIKE '%\"$the_user_id\"%'";
                  $select_projects=mysqli_query($connection,$query);
                  foreach($select_projects as $project){
                    if($project["project_status"]=='İşleme Alındı'){
                    ?>
                    <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                      <div class="d-flex align-items-start flex-column justify-content-center">
                        <a href="../pages/projects.php?project_id=<?=$project["project_id"];?>"><h6 class="mb-0 text-sm"><?=$project["project_name"];?></h6></a>
                        <p class="mb-0 text-xs"><?=$project["project_description"];?></p>
                        <p class="mb-0 text-xs"><?=date('d.m.Y',strtotime($project["project_finish_date"]));?></p>
                      </div>
                        <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto"><?=$project["project_status"];?></a>
                    </li>

                  <?php }}?>
                   
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12 mt-4">
          </div>
        </div>
      </div>
    </div>
  </div>
      <!-- Navbar Ayarları -->
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
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.0.4"></script>
   <script>
    //$('#menu-profile2').addClass('active bg-gradient-primary');
    var menu = document.querySelector('#menu-profile2');
    menu.classList.add("active");
    menu.classList.add("bg-gradient-primary");
  </script>
</body>

</html>