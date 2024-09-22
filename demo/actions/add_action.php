<?php 
session_start();
require_once "../helps.php";
include ("../includes/db.php"); 

if(!isset($_SESSION["user_id"]))
{
  header("Location: ../pages/sign-in.php");
  exit();
}

$loginUser=mysqli_query($connection,"SELECT * FROM users WHERE user_id = " . $_SESSION['user_id'])->fetch_assoc();
    
if(isset($_GET['project_id'])){
  $the_project_id = $_GET['project_id'];
  $select_project=mysqli_query($connection,"SELECT * FROM projects WHERE project_id = $the_project_id")->fetch_assoc();
}

if($_SERVER["REQUEST_METHOD"] == "POST")
  { 
if(!empty($_POST['action_detail']))
{
    $the_user_id=$_SESSION["user_id"];
    $action_detail=$_POST['action_detail'];
    $query="INSERT INTO actions (project_id,user_id,action_detail,action_date) ";
    $query.="VALUES('{$the_project_id}','$the_user_id','{$action_detail}',now())";
    $select_user=mysqli_query($connection,$query);

    if($select_user){
        $_SESSION["success"][]='İşlem eklendi';
    }
}
else
{?>
    <script>alert('Lütfen gerekli alanları doldurunuz');</script>
<?php }
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    KayraSoft | İşlem Ekle
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
      <?php if (isset($_SESSION["success"])) { ?>
          <div style="background: greenyellow;">
              <?php
              echo implode("<br />", $_SESSION["success"]);
              unset($_SESSION["success"]); ?>
          </div>
      <?php } ?>
    <div class="container-fluid py-4">
      <div class="row">
      </div>
      <?php 
      if(isset($_GET["project_id"])){?>
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Proje Ad: <?=$select_project['project_name'];?></h6>
            <h5 class="text-white text-capitalize ps-3">Yeni İşlem</h5>
        </div>

      <?php }
    else{?>
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">Yeni İşlem</h6>
            </div>
   <?php  } ?>
        <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <form class="forms-sample" action="../actions/add_action.php?project_id=<?=$the_project_id ;?>" method="post">
                      <div class="form-group mb-3">
                        <label for="project_name" style="font-size: 20px;">İşlem Açıklaması</label>
                        <textarea id="action_detail" class="form-control" name="action_detail" rows="4" cols="50" placeholder="İşlem Açıklama" style="border:1px solid gray ;"></textarea>
                      </div>
                      <div class="form-group mb-3">
                      <button type="submit" name="save_action" class="btn btn-primary mb-5">Ekle</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
  </main>
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
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.0.4"></script>
  <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  <script>
    $('#menu-actions').addClass('active bg-gradient-primary');
  </script>
</body>

</html>


