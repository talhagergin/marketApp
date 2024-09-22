<?php
session_start();
include "../includes/db.php";
require_once "../helps.php";
$breadcrumb = "Görevler";

if(!isset($_SESSION["user_id"]))
{
    header("Location: ../pages/sign-in.php");
    exit();
}

$loginUser=mysqli_query($connection,"SELECT * FROM users WHERE user_id = " . $_SESSION['user_id'])->fetch_assoc();

//user
if(isset($_GET['user_id']))
{
    $query="SELECT * FROM missions m
         INNER JOIN projects p ON m.project_id=p.project_id
         INNER JOIN users u ON m.user_id=u.user_id
         WHERE m.user_id={$_SESSION['user_id']}";
}
//admin
else{
    $query="SELECT * FROM missions m
        INNER JOIN projects p ON m.project_id=p.project_id
         INNER JOIN users u ON m.user_id=u.user_id";
}
if($_SESSION['user_role']==0){
    $query="SELECT * FROM missions m
         INNER JOIN projects p ON m.project_id=p.project_id
         INNER JOIN users u ON m.user_id=u.user_id
         WHERE m.user_id={$_SESSION['user_id']}";
}
$select_missions=mysqli_query($connection,$query)->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        KayraSoft | İşlemler
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
            <?php
            if(isset($_SESSION["success"])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php
                    echo implode("<br />", $_SESSION["success"]);
                    unset($_SESSION["success"]);
                    ?>
                </div>
            <?php } ?>
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Görevler</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">

                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7">Proje Ad</th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Kullanıcı Ad</th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Verilen Görev</th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Başlangıç Tarihi</th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Bitiş Tarihi</th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Detay Göster</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                foreach($select_missions as $mission){
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?= $mission["project_name"];?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?=$mission['username'];?></p>
                                            </td>
                                        </div>

                                        <div class="d-flex flex-column justify-content-center">
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?=substr($mission['mission_detail'],0,30);?></p>
                                            </td>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?=date('d.m.Y',strtotime($mission["mis_start_date"]));?></p>
                                            </td>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?=date('d.m.Y',strtotime($mission["mis_finish_date"]));?></p>
                                            </td>
                                        </div>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detay-<?= $mission["mis_id"]; ?>">
                                                Detay Göster
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="detay-<?= $mission["mis_id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"><?= $mission["mis_id"]; ?> - Görev Detay</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?= $mission['mission_detail']; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php  } ?>
                                </tbody>
                            </table>

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
    $('#menu-missions').addClass('active bg-gradient-primary');

    $(document).ready(function() {
        var myModal = document.getElementById('myModal')
        var myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', function () {
            myInput.focus()
        })
    });
</script>
</body>

</html>