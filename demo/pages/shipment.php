<?php
session_start();
require_once "../helps.php";
include "../includes/db.php";


if(!isset($_SESSION["user_id"]))
{
  header("Location: ../pages/sign-in.php");
  exit();
}
/*
if($_SESSION["user_role"]==0)
{
    header("Location: ../pages/dashboard.php");
    exit();
}
*/

$loginUser=mysqli_query($connection,"SELECT * FROM users WHERE user_id = " . $_SESSION['user_id'])->fetch_assoc();

$breadcrumb = "Siparişler";

if(isset($_GET['comp_id'])){
  $the_company_id = $_GET['comp_id'];
  $company_info=mysqli_query($connection,"SELECT * FROM companies WHERE company_id = $the_company_id ")->fetch_all(MYSQLI_ASSOC);

}
else{
    $queryShipment = "SELECT * FROM shipment s
                    inner join users u on s.userID = u.user_id
                    where u.user_role = 0
                    and s.actionType = 'SİPARİŞ'
                    order by s.createdDate desc";

  $shipments=mysqli_query($connection,$queryShipment)->fetch_all(MYSQLI_ASSOC);
}
//DELETE 
if(isset($_GET['delete'])){
  $the_company_id = $_GET['delete'];
  $query= "DELETE FROM companies WHERE company_id = $the_company_id";
  $delete_query=mysqli_query($connection,$query);
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
      Siparişler
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
                <h6 class="text-white text-capitalize ps-3">Siparişler</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                <div class="col-xs-3" style="margin-bottom:5px;margin-left:10px;">
                <a class="btn btn-success" href="../actions/add_company.php">Yeni Sipariş</a>
                </div>
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7">Sipariş No</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7">Müşteri Ad</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Toplam Tutar</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Ödenen Tutar</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Kalan Tutar</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Ödeme Tipi</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Sipariş Notu</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Sipariş Durumu</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Sipariş Tarihi</th>
                      <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-7 ps-2">Sipariş Detayını</th>
                      <th class="text-secondary opacity-7 ps-1">İşlemler</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                   foreach($shipments as $shipment){
                    $the_company_id=$shipment["shipmentID"];
                    $remainingAmount = $shipment["totalPrice"]- $shipment["paidAmount"];
                    ?>                
                      <tr>   
                      <td>                             
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?= $shipment["shipmentID"];?></h6>
                          </div>
                        </div>
                      </td>                     
                      <td>                             
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?= $shipment["username"];?></h6>
                          </div>
                        </div>
                      </td>
                      <div class="d-flex flex-column justify-content-center">
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$shipment['totalPrice'];?> ₺</p>
                      </td> 
                      </div>  
                      <div class="d-flex flex-column justify-content-center">
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$shipment['paidAmount'];?> ₺</p>
                      </td> 

                      <div class="d-flex flex-column justify-content-center">
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$remainingAmount;?> ₺</p>
                      </td> 
                      </div>     
                      <div class="d-flex flex-column justify-content-center">
                        <td>
                          <p class="text-xs font-weight-bold mb-0"><?=$shipment["paymentType"];?></p>
                        </td> 
                      </div>   
                      <div class="d-flex flex-column justify-content-center">
                        <td>
                          <p class="text-xs font-weight-bold mb-0"><?=$shipment["shipmentNotes"];?></p>
                        </td> 
                      </div>  
                      <div class="d-flex flex-column justify-content-center">
                        <td>
                          <p class="text-xs font-weight-bold mb-0"><?=$shipment["statusCode"];?></p>
                        </td> 
                      </div>  
                      <div class="d-flex flex-column justify-content-center">
                          <td>
                              <p class="text-xs font-weight-bold mb-0"><?=date('d.m.Y',strtotime($shipment["createdDate"]));?></p>
                          </td>
                      </div>       
                      <td>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detay-<?= $shipment["shipmentID"]; ?>">
                          Detay Göster
                        </button>
                          <!-- Modal -->
                          <div class="modal fade" id="detay-<?= $shipment["shipmentID"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel"><?= $shipment["shipmentID"]; ?> Numaralı Siparişin Detayı</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                          <div class="table-responsive p-0">
                                              <table class="table align-items-center mb-0">

                                                  <thead>
                                                  <tr>
                                                      <th>Ürün Adı</th>
                                                      <th>Birim Fiyat</th>
                                                      <th>Adet</th>
                                                      <th>Toplam Tutar</th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
                                                  <?php
                                                    $shipmentProducts = "select * from products where productID in (".$shipment["productsID"].") " ;
                                                    $selected_products=mysqli_query($connection,$shipmentProducts)->fetch_all(MYSQLI_ASSOC);
                                                    foreach($selected_products as $shipProduct){
                                                      $totalprice = $shipProduct["amount"] * $shipProduct["unitPrice"];
                                                  ?>
                                                  <tr>
                                                      <td>
                                                          <div class="d-flex px-2 py-1">
                                                              <div class="d-flex flex-column justify-content-center">
                                                                  <h6 class="mb-0 text-sm"><?= $shipProduct["productName"];?></h6>
                                                              </div>
                                                          </div>
                                                      </td>
                                                      <td>
                                                          <div class="d-flex px-2 py-1">
                                                              <div class="d-flex flex-column justify-content-center">
                                                                  <h6 class="mb-0 text-sm"><?= $shipProduct["unitPrice"];?></h6>
                                                              </div>
                                                          </div>
                                                      </td>
                                                      <td>
                                                          <div class="d-flex px-2 py-1">
                                                              <div class="d-flex flex-column justify-content-center">
                                                                  <h6 class="mb-0 text-sm"><?= $shipProduct["amount"];?></h6>
                                                              </div>
                                                          </div>
                                                      </td>
                                                      <td>
                                                          <div class="d-flex px-2 py-1">
                                                              <div class="d-flex flex-column justify-content-center">
                                                                  <h6 class="mb-0 text-sm"><?= $totalprice;?> ₺</h6>
                                                              </div>
                                                          </div>
                                                      </td>
                                                  </tr>
                                                  <?php  } ?>
                                                  <tr>
                                                    <td colspan="3" class="text-end">
                                                        <h6 class="mb-0 text-sm">Toplam Fiyat:</h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="mb-0 text-sm"><?= $shipment["totalPrice"];?> ₺</h6>
                                                    </td>
                                                </tr
                                                  </tbody>
                                              </table>

                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </td>
            
                      <td class="align-middle">
                        <button style="margin-right:5px; border-radius:5px;" title="Düzenle">
                       <a href="../actions/edit_company.php?company_id=<?= $shipment["shipmentID"]; ?>"><i class="fa fa-solid fa-pencil"></i></a>                     
                         <button style="margin-right:5px; border-radius:5px;" title="Sil">
                       <a onclick="javascript:return confirm('Firmayı silmek istediğinizden emin misiniz?');" href="firmalar.php?delete=<?= $shipment["shipmentID"]; ?>"><i class="fa fa-solid fa-trash"></i></a>
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
    $('#menu-shipment').addClass('active bg-gradient-primary');
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