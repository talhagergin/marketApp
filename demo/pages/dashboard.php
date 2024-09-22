<?php
session_start();
require_once "../helps.php";
include "../includes/db.php";
include "../functions/datetime.php";
$breadcrumb = "";

if(!isset($_SESSION["user_id"]))
{
    header("Location: ../pages/sign-in.php");
    exit();
}

$loginUser=mysqli_query($connection,"SELECT * FROM users WHERE user_id =" .$_SESSION['user_id'])->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Anasayfa
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

<!-- <div class="sidenav-footer position-absolute w-100 bottom-0 ">
  <div class="mx-3">
    <a class="btn bg-gradient-primary mt-4 w-100" href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>
  </div>
</div> -->
</aside>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include "../includes/navbar.php"; ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <?php
                        //projeler
                        $query1="SELECT COUNT(*) FROM shipment WHERE 1=1 ";

                        $query4="SELECT * FROM shipment WHERE shipmentID= 1";

                        //$query6="SELECT COUNT(*) FROM shipment WHERE DATE_FORMAT(project_start_date, '%Y-%m-%d') = '" .date("Y-m-d", time()). "'";

                        if($_SESSION["user_role"] == 0)
                        {
                            echo "asdsa";
                            $projeYetkiEk = "AND user_id LIKE '%\"{$_SESSION['user_id']}\"%'";
                            $query1 .= $projeYetkiEk;
                            $query4 .= $projeYetkiEk;
                            //$query6 .= $projeYetkiEk;

                            //işlemler
                            $query5="SELECT COUNT(*) FROM actions
                            INNER JOIN projects ON projects.project_id = actions.project_id 
                            WHERE DATE_FORMAT(actions.action_date, '%Y-%m-%d') = '" . date("Y-m-d", time()) . "'
                            AND projects.user_id LIKE '%\"{$_SESSION['user_id']}\"%'";
                            $select_actions=mysqli_query($connection,$query5)->fetch_column(0);
                        }
                       
                        else
                        {
                            //admin
                            echo "sad";
                            $query2="SELECT COUNT(*) FROM users";
                            $select_users=mysqli_query($connection,$query2)->fetch_column(0);

                            $query8="SELECT COUNT(*) FROM users WHERE DATE_FORMAT(added_date, '%Y-%m-%d') = '" .date("Y-m-d", time()). "'";
                            $select_user_new=mysqli_query($connection,$query8)->fetch_column(0);


                            $query3="SELECT COUNT(*) FROM companies";
                            $select_companies=mysqli_query($connection,$query3)->fetch_column(0);

                            $query7="SELECT COUNT(*) FROM companies WHERE DATE_FORMAT(company_added_date, '%Y-%m-%d') = '" .date("Y-m-d", time()). "'";
                            $select_company_new=mysqli_query($connection,$query7)->fetch_column(0);

                            //işlemler
                            $query5="SELECT COUNT(*) FROM actions WHERE DATE_FORMAT(action_date, '%Y-%m-%d') = '" . date("Y-m-d", time()) . "'";
                            $select_actions=mysqli_query($connection,$query5)->fetch_column(0);
                        }
                        $select_project=mysqli_query($connection,$query4)->fetch_column(0);

                        $select_fproject=mysqli_query($connection,$query4)->fetch_column(0);
                        $select_project_new=mysqli_query($connection,$query4)->fetch_column(0);
                        echo "{$select_project_new}";
                        ?>
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Projeler</p>
                            <h4 class="mb-0"><?=$select_project;?></h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder"><?=$select_project_new;?> Yeni <a href="../pages/projects.php">Proje</a> </span></p>
                    </div>
                </div>
            </div>
            <?php if ($_SESSION["user_role"] == 1) { ?>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">store</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Müşteriler</p>
                            <h4 class="mb-0"><?=$select_companies;?></h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder"><?=$select_company_new ;?> Yeni <a href="../pages/firmalar.php">Müşteri</a></span></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">engineering</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Personeller</p>
                            <h4 class="mb-0"><?=$select_users;?></h4>

                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-danger text-sm font-weight-bolder"><?=$select_user_new ;?> Yeni <a href="../pages/kullanıcılar.php">Personel</a></span></p>

                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Yapılan İşlem Sayısı</p>
                            <h4 class="mb-0"><?=$select_actions;?></h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <p class="mb-0"><span class="text-success text-sm font-weight-bolder"><a href="../pages/actions.php">Günlük Yapıılan İşlem Sayısı</a></span></p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-5">
            <!-- Proje Takip Tablosu Başlangıç-->
            <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Projeler</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-check text-info" aria-hidden="true"></i>
                                    <span class="font-weight-bold ms-1"><?=$select_fproject;?></span>
                                </p>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Firmalar</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Projeler</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Personeller</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kalan Süre</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Proje Duruumu</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $query="SELECT * FROM projects p INNER JOIN companies c on p.company_id = c.company_id";
                                if($_SESSION["user_role"] == 0)
                                {
                                    $query .= " WHERE p.user_id LIKE '%\"{$_SESSION['user_id']}\"%'";
                                }

                                $projects=mysqli_query($connection,$query)->fetch_all(MYSQLI_ASSOC);

                                foreach($projects as $project){
                                $user_id=json_decode($project['user_id']);
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm"><a href="../pages/firmalar.php?comp_id=<?=$project["company_id"];?>"><?=$project["company_name"];?></a></h6>
                                        </div>
                        </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm"><a href="../pages/projects.php?project_id=<?=$project["project_id"];?>"><?=$project["project_name"];?></a></h6>
                            </div>
                    </div>
                    </td>
                    <td>
                        <!-- Kullanıcı Resimleri -->
                        <?php
                        if(count($user_id) > 0) {
                            $projePersonelleri = mysqli_query($connection, "SELECT * FROM users WHERE user_id IN (".implode(",", $user_id).")")->fetch_all(MYSQLI_ASSOC);


                            foreach($projePersonelleri as $projePersoneli) { ?>
                                <div class="avatar-group mt-2" style="float:left";>
                                    <a href="../pages/profile.php?user_id=<?=$projePersoneli["user_id"];?>" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?=$projePersoneli["username"] ;?>">
                                        <img src="../assets/img/user_image/<?=$projePersoneli["user_image"];?>" alt="">
                                    </a>
                                </div>

                            <?php } } ?>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"><?=diffDate(date("Y-m-d", time()), $project["project_finish_date"]); ?></span>
                    </td>
                    <td class="align-middle">
                        <div class="progress-wrapper w-75 mx-auto">
                            <div class="progress-info">
                                <div class="progress-percentage">
                                    <span class="text-xs font-weight-bold"><?=$project["project_status"];?></span>
                                </div>
                            </div>
                            <div class="progress">
                                <?php
                                switch ($project["project_status"]) {
                                    case 'Bekliyor': ?>
                                        <div class="progress-bar bg-gradient-warning w-100" role="progressbar"
                                             aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php break;
                                    case 'İşleme Alındı': ?>
                                        <div class="progress-bar bg-gradient-info w-50" role="progressbar"
                                             aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php break;
                                    case 'Bitti': ?>
                                        <div class="progress-bar bg-gradient-success w-100" role="progressbar"
                                             aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        <?php break;
                                    case 'İptal Edildi': ?>
                                        <div class="progress-bar bg-gradient-danger w-100" role="progressbar"
                                             aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        <? break; default : ?>
                                <?php } ?>

                            </div>
                        </div>
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
<?php include "../includes/navbar_settings.php"; ?>
<!--   Core JS Files   -->
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="../assets/js/plugins/chartjs.min.js"></script>
<script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["M", "T", "W", "T", "F", "S", "S"],
            datasets: [{
                label: "Sales",
                tension: 0.4,
                borderWidth: 0,
                borderRadius: 4,
                borderSkipped: false,
                backgroundColor: "rgba(255, 255, 255, .8)",
                data: [50, 20, 10, 22, 50, 10, 40],
                maxBarThickness: 6
            }, ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 500,
                        beginAtZero: true,
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                        color: "#fff"
                    },
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    new Chart(ctx2, {
        type: "line",
        data: {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Mobile apps",
                tension: 0,
                borderWidth: 0,
                pointRadius: 5,
                pointBackgroundColor: "rgba(255, 255, 255, .8)",
                pointBorderColor: "transparent",
                borderColor: "rgba(255, 255, 255, .8)",
                borderColor: "rgba(255, 255, 255, .8)",
                borderWidth: 4,
                backgroundColor: "transparent",
                fill: true,
                data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
                maxBarThickness: 6

            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });

    var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

    new Chart(ctx3, {
        type: "line",
        data: {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Mobile apps",
                tension: 0,
                borderWidth: 0,
                pointRadius: 5,
                pointBackgroundColor: "rgba(255, 255, 255, .8)",
                pointBorderColor: "transparent",
                borderColor: "rgba(255, 255, 255, .8)",
                borderWidth: 4,
                backgroundColor: "transparent",
                fill: true,
                data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                maxBarThickness: 6

            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#f8f9fa',
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
</script>
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
    $('#menu-dashboard').addClass('active bg-gradient-primary');
</script>
</body>

</html>