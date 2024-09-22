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

$the_project_id=$_GET['p_id'];

$query = "SELECT * FROM projects INNER JOIN companies ON companies.company_id=projects.company_id  WHERE project_id={$the_project_id}";
$projects=mysqli_query($connection,$query);
while($row=mysqli_fetch_array($projects)){
    $project_name=$row['project_name'];
    $company_name=$row['company_name'];
    $project_status=$row['project_status'];
    $project_start_date=$row['project_start_date'];
    $project_finish_date=$row['project_finish_date'];
    $project_image=$row['project_image'];
    $project_description=$row['project_description'];
    $user_id=json_decode($row['user_id']);
}


if(!$projects)
{
    die("You must login");
} 

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id'])) {


        $query = "UPDATE projects SET 
    project_name= '{$_POST["project_name"]} ',
    project_status='{$_POST["project_status"]} ',
    project_start_date='{$_POST["project_start_date"]} ',
    project_finish_date='{$_POST["project_finish_date"]} ',
    project_description='{$_POST["project_description"]} ',
    user_id= '" . json_encode($_POST["user_id"]) . "'
    WHERE project_id='{$the_project_id}'";
        $update_project = mysqli_query($connection, $query);

        header("Location: {$_SERVER["PHP_SELF"]}?p_id={$the_project_id}");
    }
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
    KayraSoft | Proje Düzenle
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
            <h6 class="text-white text-capitalize ps-3">Proje Düzenleme</h6>
        </div>
        <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"><?=$project_name;?></h4>
                    <form class="forms-sample" action="<?= $_SERVER["PHP_SELF"]; ?>?p_id=<?=  $the_project_id=$_GET['p_id']; ?>" method="post">
                      <div class="form-group">
                        <label for="project_name" style="font-size: 20px;">Proje Ad</label>
                        <input type="text" class="form-control" placeholder="Name" name="project_name" value="<?= $project_name;?>" style="border:1px solid gray">
                      </div>
                      <div class="form-group">
                        <label for="company_name"style="font-size: 20px;">Firma Ad</label>
                        <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Firma Ad" value="<?= $company_name;?>"style="border:1px solid gray" disabled>
                      </div>
                      <div class="form-group">
                        <label for="project_status"style="font-size: 20px;">Proje Durumu</label>
                        <select name="project_status" id="project_status" style="border:1px solid gray;border-radius: 5px;" class="form-control">
                            <option value='Bekliyor' <?=  $project_status == 'Bekliyor' ? 'selected' : ''; ?>>Bekliyor</option>
                            <option value='İşleme Alındı' <?=  $project_status == 'İşleme Alındı' ? 'selected' : ''; ?>>İşleme Alındı</option>
                            <option value='Bitti' <?=  $project_status == 'Bitti' ? 'selected' : ''; ?>>Bitti</option>
                            <option value='İptal Edildi' <?=  $project_status == 'İptal Edildi' ? 'selected' : ''; ?>>İptal Edildi</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="project_start_date">Başlangıç Tarihi</label>
                        <input type="date" name="project_start_date" class="form-control" id="project_start_date" placeholder="Start Date" value="<?= $project_start_date;?>"style="border:1px solid gray;width:auto;">
                      </div>
                      <div class="form-group">
                        <label for="project_finish_date">Bitiş Tarihi</label>
                        <input type="date" name="project_finish_date" class="form-control" id="project_finish_date" placeholder="Finish Date" value="<?= $project_finish_date;?>"style="border:1px solid gray;width:auto;margin-bottom:10px;">
                      </div>
                      <div class="form-group">
                        <label for="project_status"style="font-size: 20px;">Projeden Sorumlu Kişiler</label><br>
                          <tbody>
                          <?php
                          $query="SELECT * FROM users";
                          $select_users=mysqli_query($connection, $query)->fetch_all(MYSQLI_ASSOC);
                          foreach ($select_users as $user){?>
                          <tr>
                              <td>
                                  <input class="checkBoxes" type="checkbox" name="user_id[]" value="<?= $user["user_id"]; ?>" <?= in_array($user['user_id'], $user_id) ? 'checked' : ''; ?>  />
                              </td>
                              <td><?= $user["user_firstname"]." ".$user["user_lastname"]; ?></td>
                          </tr>
                          </tbody>
                          <?php }?>
                      </div>
                      <div class="form-group mb-3">
                        <label for="project_name" style="font-size: 20px;">Proje Açıklaması</label>
                        <textarea id="project_description" class="form-control"  name="project_description" rows="4" cols="50" placeholder="Proje Açıklama" style="border:1px solid gray ;"><?= $project_description;?></textarea>
                      </div>
                      <button type="submit" name="save_project" class="btn btn-primary mr-2">Kaydet</button>
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
    $('#menu-projeler').addClass('active bg-gradient-primary');
  </script>
</body>

</html>
