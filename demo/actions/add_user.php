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
   
if(!empty($_POST['username']) && !empty($_POST['name']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['phone']))
{

    $username=$_POST['username'];
    $name=$_POST['name'];
    $lastname=$_POST['lastname'];
    $email=$_POST['email'];

    //Same User control

    $select_same_user=mysqli_query($connection,"SELECT * FROM users WHERE user_email LIKE  '%$email%'")->fetch_all(MYSQLI_ASSOC);
    if($select_same_user)
    {
        $_SESSION["errors"][]='Bu e posta zaten sisteme kayıtlı!';
        header('Location: ../actions/add_user.php');
        exit();
    }

    $phone=$_POST['phone'];
    $password=$_POST['password'];
    $role=$_POST['user_role'];
    if(isset($_FILES['image']['name']) && empty($_FILES['image']['name'])){
        $_FILES['image']['name'] = 'logo.png';
    }
    $user_image=$_FILES['image']['name'];
    $user_image_temp =$_FILES['image']['tmp_name'];

    move_uploaded_file($user_image_temp,"../assets/img/user_image/$user_image");
    $query="INSERT INTO users (username,user_firstname,user_lastname,user_email,user_phone,user_password,user_role,user_image,added_date) ";
    $query.="VALUES('{$username}','{$name}','{$lastname}','{$email}','{$phone}','{$password}','{$role}','{$user_image}',now())";
    $select_user=mysqli_query($connection,$query);
    header("Location: ../pages/kullanıcılar.php");

    
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
?>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    KayraSoft | Kullanıcı Ekle
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
      <?php if (isset($_SESSION["errors"])) { ?>
          <div style="background: red;">
              <?php
              echo implode("<br />", $_SESSION["errors"]);
              unset($_SESSION["errors"]); ?>
          </div>
      <?php } ?>
    <div class="container-fluid py-4">
      <div class="row">
   
      </div>
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h6 class="text-white text-capitalize ps-3">Yeni Kullanıcı</h6>
        </div>
        <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <form class="forms-sample" action="../actions/add_user.php" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="project_name" style="font-size: 20px;">Kullanıcı Ad</label>
                        <input type="text" class="form-control" placeholder="Kullanıcı Ad" value="" name="username" style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Ad</label>
                        <input type="text" class="form-control" id="user_firstname" placeholder="Ad" name="name" value=""style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Soyad</label>
                        <input type="text" class="form-control" id="user_lastname" placeholder="Soyad" name="lastname" value=""style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Email</label>
                        <input type="email" class="form-control" id="user_email" placeholder="Email" name="email" value=""style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Telefon</label>
                        <input type="text" class="form-control" id="user_phone" placeholder="Telefon" name="phone" value=""style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Şifre</label>
                        <input type="password" class="form-control" id="user_password" placeholder="Şifre" name="password" value=""style="border:1px solid gray">
                      </div>
                        <div class="form-group">
                            <label for="project_status"style="font-size: 20px;">Kullanıcı Tipi</label>
                            <select name="user_role" id="user_role" style="border:1px solid gray;border-radius: 5px;" class="form-control">
                                <option value=0>Personel</option>
                                <option value=1> Admin</option>
                                <option value=2> Müşteri</option>
                            </select>
                        </div>
                        <div class="form-group"style="margin-bottom: 10px; margin-top: 10px;">
                            <label>Profil Fotoğrafı</label>
                            <img class="form-control max-width-200" src="../assets/img/user_image/logo.png" alt="">
                            <input type="file" name="image" class="file-upload-default">
                        </div>
                      <button type="submit" name="create_user" class="btn btn-primary mb-5">Ekle</button>
                    </form>
                  </div>
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
    $('#menu-kullanıcılar').addClass('active bg-gradient-primary');
  </script>
</body>

</html>


