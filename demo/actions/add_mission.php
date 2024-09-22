<?php
session_start();

include ("../includes/db.php");
require_once "../helps.php";

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

if(isset($_GET['user_id']))
{
    $select_users_check=mysqli_query($connection,"SELECT * FROM users WHERE user_id={$_GET['user_id']}")->fetch_assoc();

}


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (!empty($_POST['mission_start_date']) && !empty($_POST['mission_finish_date']) && !empty($_POST['mission_description'])) {
        $project_id = $_POST['project_name'];
        $user_id = $_GET['user_id'];
        $mission_start_date = $_POST['mission_start_date'];
        $mission_finish_date = $_POST['mission_finish_date'];
        $mission_description = $_POST['mission_description'];
        $query = "INSERT INTO missions (project_id,user_id,mis_start_date,mis_finish_date,mission_detail) ";
        $query .= "VALUES('{$project_id}','{$user_id}','{$mission_start_date}','{$mission_finish_date}','{$mission_description}')";
        $select_user=mysqli_query($connection,$query);
        if ($select_user) {
            $_SESSION['success'][] = "Görev kullanıcıya tanımlandı";
            header("Location: ../pages/missions.php");
        } else {
            $_SESSION['errors'][] = "Görev kullanıcıya tanımlanamadı";
            header("Location: ../pages/add_mission.php?user_id=<?=$user_id;?>");
        }

    }
    else
    {?>
        <script>alert('Lütfen gerekli alanları doldurunuz');</script>
    <?php }
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
        KayraSoft | Görev Ekle
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
            <h6 class="text-white text-capitalize ps-3">Yeni Görev</h6>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"></h4>
                <form class="forms-sample" action="../actions/add_mission.php?user_id=<?=$_GET['user_id'];?>" method="post">
                    <div class="form-group mb-3">
                        <label for="user_name"style="font-size: 20px;">Kullanıcı Ad</label>
                        <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Kullanıcı Ad" value="<?= $select_users_check['username'];?>" style="border:1px solid gray" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label for="project_name"style="font-size: 20px;">Proje Ad</label>
                        <div>
                            <a href="../actions/add_project.php"><i class="fa fa-solid fa-plus"></i>Yeni Proje Ekle</a>
                            <select name="project_name" id="project_name" style="border:1px solid gray;border-radius: 5px;" class="form-control">
                                <?php
                                $query="SELECT * FROM projects";
                                $select_projects=mysqli_query($connection,$query)->fetch_all(MYSQLI_ASSOC);
                                foreach($select_projects as $project){?>
                                    <option value='<?=$project['project_id'] ;?>'><?=$project['project_name'] ;?></option>
                                <?php }?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="project_start_date">Başlangıç Tarihi</label>
                        <input type="date" name="mission_start_date" class="form-control" id="mission_start_date" placeholder="Start Date" style="border:1px solid gray;width:auto;">
                    </div>
                    <div class="form-group mb-3">
                        <label for="project_finish_date">Bitiş Tarihi</label>
                        <input type="date" name="mission_finish_date" class="form-control" id="mission_finish_date" placeholder="Finish Date" style="border:1px solid gray;width:auto;margin-bottom:10px;">
                    </div>

                    <div class="form-group mb-3">
                        <label for="mission_description" style="font-size: 20px;">Görev Açıklaması</label>
                        <textarea id="mission_description" class="form-control" name="mission_description" rows="4" cols="50" placeholder="Görev Açıklama" style="border:1px solid gray ;"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" name="create_mission" class="btn btn-primary mb-5">Ekle</button>
                    </div>
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
    $('#menu-missions').addClass('active bg-gradient-primary');
</script>
</body>

</html>


