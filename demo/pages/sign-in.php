<?php 
require_once "../helps.php";
include "../includes/db.php";
session_start();

if(isset($_SESSION["user_id"]))
{
  header("Location: ../pages/dashboard.php");
  exit();
}

$isLogin=false;
if(isset($_POST['login'])){
  $email = $_POST['email'];
  $password=$_POST['password'];

  $query="SELECT * FROM users WHERE user_email='{$email}' and user_password='{$password}'";
  $user=mysqli_query($connection,$query) ->fetch_assoc();

  if(!$user){
    $_SESSION["isLogin"]=false;
    $_SESSION["errors"][]="Kullanıcı adı ya da şifre hatalı!";
  }
  else{
  $_SESSION["user_id"] = $user["user_id"];
  $_SESSION["user_role"]= $user["user_role"];
  
if(isset($_SESSION["user_id"])){
  $_SESSION["isLogin"]=true;
  header("Location: ../pages/dashboard.php");
}
  }
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
    Kayrasoft | Giriş
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

<body class="bg-gray-200">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12 ">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-xl top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid">
            <a class="navbar-brand font-weight-bolder" style="margin-left:450px ;" href="<?php if($isLogin){ url('pages/dashboard.php?');} else{url('pages/sign-in.php?');}?>">
              <img src="../assets/img/logo.png"  style=width:150px;>
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            </button>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
            <?php
            if(isset($_SESSION["errors"])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo implode("<br />", $_SESSION["errors"]);
                    unset($_SESSION["errors"]);
                    ?>
                </div>
            <?php } ?>
          <div class="col-lg-4 col-md-8 col-12 mx-auto" style="margin-top: 20px;">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Giriş</h4>
                </div>
              </div>
              <div class="card-body">
                <form role="form" class="text-start" action="" method="post">
                  <div class="input-group input-group-outline my-3">
                    <input type="email" class="form-control" placeholder="Email" name="email">
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2" name="login">Giriş</button>
                  </div>
                  <p class="mt-4 text-sm text-center">
                    Hesabınız yok mu?
                    <a href="../pages/sign-up.php" class="text-primary text-gradient font-weight-bold">Kaydol</a>
                  </p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
        <footer class="footer position-absolute bottom-2 py-2 w-100">
          <div class="container">
            <div class="row align-items-center justify-content-lg-between">
            </div>
          </div>
        </footer>
      </div>
    </main>
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
  </body>

  </html>