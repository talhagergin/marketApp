<?php 
session_start();
include ("../includes/db.php");  

if(!isset($_SESSION["user_id"]))
{
  header("Location: ../pages/sign-in.php");
  exit();
}

$loginUser=mysqli_query($connection,"SELECT * FROM users WHERE user_id = " . $_SESSION['user_id'])->fetch_assoc();

if(isset($_GET['user_id'])){
    //Veritabanında olup olmama controlü
    $the_user_id= $_GET['user_id'];
    //kullanıcı başkasını düzenlemeye çalıştığında
    if($the_user_id != $_SESSION['user_id']) {
        if ($_SESSION['user_role'] == 0) {
            header("Location: ../pages/dashboard.php");
            exit();
        }
        else{
            $query = "SELECT * FROM users WHERE user_id={$the_user_id}";
            $users=mysqli_query($connection,$query)->fetch_assoc();
            $user_image=$users['user_image'];

        }
    }
    else
    {
        $query = "SELECT * FROM users WHERE user_id={$the_user_id}";
        $users = mysqli_query($connection, $query)->fetch_assoc();
        $user_image = $users['user_image'];
    }
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $user_image=$_FILES['image']['name'];
            $user_image_temp =$_FILES['image']['tmp_name'];

            move_uploaded_file($user_image_temp,"../assets/img/user_image/$user_image");
        }

        $query="UPDATE users SET 
        username= '{$_POST["username"]} ',
        user_firstname='{$_POST["name"]}',
        user_lastname='{$_POST["name"]} ',
        user_email='{$_POST["email"]} ',
        user_phone='{$_POST["phone"]} ',
        user_password='{$_POST["password"]} ',
        user_role='{$_POST["user_role"]}',
        user_image ='{$user_image}' 
        WHERE user_id='{$the_user_id}'";
        $update_user=mysqli_query($connection,$query);

        header("Location: {$_SERVER["PHP_SELF"]}?user_id={$the_user_id}");
    }
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
    KayraSoft | Kullanıcı Düzenle
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
            <h6 class="text-white text-capitalize ps-3"><?=$users['username'];?></h6>
        </div>
        <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <form class="forms-sample" action="<?= $_SERVER["PHP_SELF"]; ?>?user_id=<?=  $the_user_id=$_GET['user_id']; ?>" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="project_name" style="font-size: 20px;">Kullanıcı Ad</label>
                        <input type="text" class="form-control" placeholder="Kullanıcı Ad" value="<?=$users['username']?>" name="username" style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Ad</label>
                        <input type="text" class="form-control" id="user_firstname" placeholder="Ad" name="name" value="<?=$users['user_firstname']?>"style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Soyad</label>
                        <input type="text" class="form-control" id="user_lastname" placeholder="Soyad" name="lastname" value="<?=$users['user_lastname']?>"style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Email</label>
                        <input type="email" class="form-control" id="user_email" placeholder="Email" name="email" value="<?=$users['user_email']?>"style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Telefon</label>
                        <input type="text" class="form-control" id="user_phone" placeholder="Telefon" name="phone" value="<?=$users['user_phone']?>"style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="project_status"style="font-size: 20px;">Kullanıcı Tipi</label>
                        <select name="user_role" id="project_status" style="border:1px solid gray;border-radius: 5px;" class="form-control">
                            <option value=0 <?=  $users['user_role'] == 0 ? 'selected' : ''; ?>>Personel</option>
                            <option value=1 <?= $users['user_role'] == 1 ? 'selected' : ''; ?>> Admin</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Şifre</label>
                        <input type="text" class="form-control" id="user_password" placeholder="Şifre" name="password" value="<?=$users['user_password']?>"style="border:1px solid gray">
                      </div>
                      <div class="form-group"style="margin-bottom: 10px; margin-top: 10px;">
                        <label>Profil Fotoğrafı</label>
                          <img class="form-control max-width-200" src="../assets/img/user_image/<?=$users['user_image'];?>" alt="">
                        <input type="file" name="image" class="file-upload-default">
                      </div>
                      <button type="submit" name="save_user" class="btn btn-primary mb-5 mt-3">Kaydet</button>
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



