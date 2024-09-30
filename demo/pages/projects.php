<?php 
session_start();
include "../includes/db.php";
require_once "../helps.php";

$breadcrumb = "Siparişler";


if(!isset($_SESSION["user_id"]))
{
  header("Location: ../pages/sign-in.php");
  exit();
}


$loginUser=mysqli_query($connection,"SELECT * FROM users WHERE user_id = " . $_SESSION['user_id'])->fetch_assoc();

 //Projeleri Veritabanından Çekme
if(isset($_GET['personal_id']))
{
  $the_user_id = $_GET['personal_id'];
  if($_SESSION['user_role']== 0)
  {
      if ($the_user_id != $_SESSION['user_id'])
      {
          header("Location: ../pages/dashboard.php");
          exit();
      }
      else
      {
          $query = "SELECT *FROM projects  INNER JOIN companies ON projects.company_id=companies.company_id WHERE user_id LIKE '%\"$the_user_id\"%'";
          $projects = mysqli_query($connection, $query)->fetch_all(MYSQLI_ASSOC);
          $query2 = "SELECT * FROM users WHERE user_id=$the_user_id";
          $user = mysqli_query($connection, $query2)->fetch_assoc();
      }
  }
  else
  {
//      $query = "SELECT *FROM projects  INNER JOIN companies ON projects.company_id=companies.company_id WHERE user_id LIKE '%\"$the_user_id\"%'";
      $query = "SELECT *FROM shipment   WHERE user_id LIKE '%\"$the_user_id\"%'";
      $projects = mysqli_query($connection, $query)->fetch_all(MYSQLI_ASSOC);
      $query2 = "SELECT * FROM users WHERE user_id=$the_user_id";
      $user = mysqli_query($connection, $query2)->fetch_assoc();
  }

}
else if(isset($_GET['company_id'])){
  $the_company_id=$_GET['company_id'];
  $query="SELECT * FROM projects WHERE company_id = $the_company_id";
  $projects=mysqli_query($connection,$query)->fetch_all(MYSQLI_ASSOC);
  $query2="SELECT company_name FROM companies WHERE company_id= $the_company_id";
  $company=mysqli_query($connection,$query2)->fetch_assoc();
}
else if(isset($_GET['project_id'])){
  $the_project_id = $_GET['project_id'];
  $query= "SELECT *FROM projects INNER JOIN companies ON projects.company_id = companies.company_id WHERE project_id= $the_project_id";
  if($_SESSION["user_role"] == 0)
  {
      $query .= " AND projects.user_id LIKE '%\"{$_SESSION['user_id']}\"%'";
  }
  $projects=mysqli_query($connection,$query)->fetch_all(MYSQLI_ASSOC);

  if($_SESSION["user_role"] == 0 && !$projects)
  {
      header('Location: ../pages/dashboard.php');
      exit();
  }
}

else{
    if($_SESSION["user_role"] == 1)
    {
        $query= "SELECT *FROM projects  INNER JOIN companies ON projects.company_id=companies.company_id";
        $projects=mysqli_query($connection,$query)->fetch_all(MYSQLI_ASSOC);
    }
    else
    {
        $query= "SELECT *FROM projects  INNER JOIN companies ON projects.company_id=companies.company_id WHERE user_id LIKE '%\"{$_SESSION['user_id']}\"%'";
        $projects=mysqli_query($connection,$query)->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<?php
        //DELETE 
        if(isset($_GET['delete'])){
          $the_project_id = $_GET['delete'];
          $query= "DELETE FROM projects WHERE project_id = $the_project_id";
          $delete_query=mysqli_query($connection,$query);
          header("Location: {$_SERVER["PHP_SELF"]}");
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
    Projeler
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
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                
                <h6 class="text-white text-capitalize ps-3">
                <?php 
                if(isset($_GET['personal_id'])){
                  echo $user['username'];
                }
                else if(isset($_GET['company_id'])){
                  echo $company['company_name'];
                }
                ?>
                Projeler <br>Toplam Proje Sayısı: <?= count($projects); ?>
              </h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
               <?php  if(!isset($_GET['personal_id'])&& !isset($_GET['company_id'])){?>
                <div class="col-xs-3" style="margin-bottom: 15px;margin-left:20px;">
                    <?php
                   if($_SESSION["user_role"] == 1){?>
                    <a class="btn btn-success" href="../actions/add_project.php">Yeni Proje</a>
                  <?php } ?>
                </div>
                <?php }?>
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7">Proje Ad</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-1">Firma Ad</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-1">Başlangıç Tarih</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-1">Bitiş Tarih</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-1">Durumu</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-1">Açıklama</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-1">İşlemler</th>
                    </tr>
                  </thead>
                  <tbody>
                        <?php 
                    foreach($projects as $project){?>
                      <tr>
                      <td class="align-middle text-center">
                      <div class="my-auto">
                            <h6 class="mb-0 text-sm"><?=$project["project_name"] ;?></h6>
                          </div>
                      </td>
                       <td>
                        <?php
                         if(!empty($company))
                         {?>
                          <p class="text-sm font-weight-bold mb-0"><?=$company["company_name"];?></p>
                        <?php } 
                        else{?>
                        <p class="text-sm font-weight-bold mb-0"><?=$project["company_name"];?></p>
                      <?php } ?>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?=date('d.m.Y',strtotime($project["project_start_date"]));?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?=date('d.m.Y',strtotime($project["project_finish_date"]));?></p>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold"><?= $project["project_status"];?></span>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold"><?= $project["project_description"];?></span>
                      </td>
                      
                      <td class="align-middle">
                          <?php
                          if($_SESSION['user_role']==1){?>
                        <button title="Düzenle" style="margin-right:5px; border-radius:5px;">
                       <a href="../actions/edit_project.php?p_id=<?= $project["project_id"]; ?>"><i class="fa fa-solid fa-pencil"></i></a>                     
                         <button style="margin-right:5px; border-radius:5px;" title="Sil">
                       <a onclick="javascript:return confirm('Are you sure you want to delete this?');" href="projects.php?delete=<?= $project["project_id"]; ?>"><i class="fa fa-solid fa-trash"></i></a>
                       <button title="Yapılan İşlemler" style="margin-right:5px; border-radius:5px;">
                       <a href="actions.php?p_id=<?= $project["project_id"]; ?>"><i class="fa fa-solid fa-search"></i></a>
                      </button>
                             <?php }?>
                      <button style="margin-right:5px; border-radius:5px;" title="İşlem Ekle">
                       <a href="../actions/add_action.php?project_id=<?=$project["project_id"]; ?>"><i class="fa fa-solid fa-plus"></i></a>
                      </button>
                        </button>
                      </td>
                    </tr>
                       <?php } ?>   

                  </tbody>
                </table>
                
              </div>
            </div>
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
    $('#menu-projeler').addClass('active bg-gradient-primary');
  </script>
</body>

</html>
