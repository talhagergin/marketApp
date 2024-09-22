<?php
session_start();
require_once "../helps.php";
include "../includes/db.php";
$breadcrumb = "Personeller";


if(!isset($_SESSION["user_id"]))
{
  header("Location: ../pages/sign-in.php");
  exit();
}

$loginUser=mysqli_query($connection,"SELECT * FROM users WHERE   user_id = " . $_SESSION['user_id'])->fetch_assoc();

?>
<?php
        //DELETE user
        if(isset($_GET['delete'])){
          $the_user_id = $_GET['delete'];
          $query= "DELETE FROM users WHERE user_id = $the_user_id";
          $delete_query=mysqli_query($connection,$query);
        }?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Müşteriler
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
                <h6 class="text-white text-capitalize ps-3">Müşteriler</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                <div class="col-xs-3" style="margin-bottom:5px;margin-left:10px;">
                <a class="btn btn-success" href="../actions/add_user.php">Yeni Müşteri</a>
                <input type="text" id="searchField" placeholder="Müşteri Ara" class="form-control" style="display:inline-block; width:auto; margin-left:10px;">
                <button id="searchButton" class="btn btn-primary" style="margin-left: 10px;">Ara</button>
                </div>
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7">Müşteri Ad</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Telefon</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Toplam Borç</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">İşlemler</th>
                      <th class="text-secondary opacity-7 ps-1">İşlemler</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $user_info=mysqli_query($connection,"SELECT * FROM users where user_role = 0")->fetch_all(MYSQLI_ASSOC);
                   foreach($user_info as $user){
                   // $the_user_id=json_encode($user["user_id"]);
                    //$project_info=mysqli_query($connection,"SELECT * FROM projects WHERE user_id LIKE '%\"$the_user_id\"%'") ->fetch_all(MYSQLI_ASSOC);                        
                    ?>                
                      <tr>                       
                      <td>                             
                        <div class="d-flex px-2 py-1">
                          <div>
                            <a href="../pages/profile.php?user_id=<?=$user["username"];?>">
                            
                          </a>
                        </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?= $user["username"];?></h6>
                            <p class="text-xs text-secondary mb-0"><?= $user["lastname"]; ?></p>
                          </div>
                        </div>
                      </td>
                      <div class="d-flex flex-column justify-content-center">
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$user['user_phone'];?></p>
                      </td> 
                      </div>     
                      <div class="d-flex flex-column justify-content-center">
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$user['totalAmount'];?> ₺</p>
                      </td> 
                      </div>                 
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><a href="../pages/projects.php?personal_id=<?= $user['user_id'] ;?>">Projeleri Görüntüle</a></p>
                      </td>
                           
                      <td class="align-middle">
                        <button style="margin-right:5px;" title="Düzenle">
                        <a href="../actions/edit_user.php?user_id=<?=$user['user_id'];?>" <i class="fa fa-solid fa-pencil"></i></a>
                        <button title="Sil">
                        <a onclick="javascript:return confirm('Kullanıcıyı Silmek İstediğinizden Emin Misiniz?');" href="kullanıcılar.php?delete=<?= $user["user_id"]; ?>"><i class="fa fa-solid fa-trash"></i></a>
                        </button>
                            <button title="Görev Ekle">
                                <a  href="../actions/add_mission.php?user_id=<?= $user["user_id"]; ?>"><i class="fa fa-solid fa-plus"></i></a>
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
    $('#menu-kullanıcılar').addClass('active bg-gradient-primary');
  </script>
</body>

</html>