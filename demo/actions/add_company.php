<?php 
session_start();
include ("../includes/db.php"); 

if(!isset($_SESSION["user_id"]))
{
  header("Location: ../pages/sign-in.php");
  exit();
}

if($_SESSION['user_role']==0)
{
    header("Location: ../pages/dashboard.php");
    exit();
}

$loginUser=mysqli_query($connection,"SELECT * FROM users WHERE user_id = " . $_SESSION['user_id'])->fetch_assoc();

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {

if(!empty($_POST['company_name']) && !empty($_POST['company_adress']) && !empty($_POST['company_phone']))
{
    $company_name=$_POST['company_name'];
    $company_adress=$_POST['company_adress'];
    $company_phone=$_POST['company_phone'];
    $company_email=$_POST['company_email'];
    $query="INSERT INTO companies (company_name,company_adress,company_phone,company_email,company_added_date) ";
    $query.="VALUES('{$company_name}','{$company_adress}','{$company_phone}','{$company_email}',now())";
    $added_company=mysqli_query($connection,$query);
    if($added_company){
      "<script>alert('Firma Eklendi')</script>";
      header("Location: ../pages/dashboard.php");
    }
}
else
{?>
    <script>alert('Lütfen gerekli alanları doldurunuz');</script>
<?php }
}  
?>
<!DOCTYPE html>
<?php
require_once "../helps.php";
// if(!$_SESSION["isLogin"]){
//   die("You must login");
// }
?>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    KayraSoft | Firma Ekle
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
   
      </div>
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Yeni Firma</h6>
        </div>
        <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <form class="forms-sample" action="../actions/add_company.php" method="post">
                      <div class="form-group">
                        <label for="project_name" style="font-size: 20px;">Firma Ad</label>
                        <input type="text" class="form-control" placeholder="Firma Ad" id="company_name" name="company_name" style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Firma Adres</label>
                        <input type="text" class="form-control" id="company_adress" placeholder="Firma Adres" name="company_adress" value=""style="border:1px solid gray">
                      </div>
                      <div class="form-group mb-3">
                        <label for="company_name"style="font-size: 20px;">Firma Telefon</label>
                        <input type="text" class="form-control" id="company_phone" placeholder="Firma Telefon" name="company_phone" style="border:1px solid gray">
                      </div>
                      <div class="form-group mb-3">
                        <label for="company_name"style="font-size: 20px;">Firma E-Posta</label>
                        <input type="email" class="form-control" id="company_email" placeholder="Firma E-Posta" name="company_email" style="border:1px solid gray">
                      </div>
                      <button type="submit" name="create_user" class="btn btn-primary mb-5">Ekle</button>
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
    $('#menu-firmalar').addClass('active bg-gradient-primary');
  </script>
</body>

</html>


