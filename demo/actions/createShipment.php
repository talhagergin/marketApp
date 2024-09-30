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

$users_query = "SELECT * FROM users WHERE user_role = 0";
$users = mysqli_query($connection, $users_query)->fetch_all(MYSQLI_ASSOC);

   if($_SERVER["REQUEST_METHOD"] == "POST")
    {
    var_dump($_POST);
    $customerName = $_POST['customerName'];
    $productIDs = $_POST['productID']; 
    $quantities = $_POST['quantity']; 
    $prices = $_POST['price']; 
    $totals = $_POST['total']; 
    $productsIDsString = implode(",", array_filter($productIDs)); 
    die($productsIDsString);


    if($added_company){
      "<script>alert('Firma Eklendi')</script>";
      header("Location: ../pages/dashboard.php");
    }
   // <script>alert('Lütfen gerekli alanları doldurunuz');</script>
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
   Yeni Sipariş
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

<div class="container mt-5">
    <h2>Yeni Sipariş</h2>
    <div class="d-flex align-items-center">
            <button class="btn btn-primary" id="addRow">Yeni Satır</button>
            <input type="text" class="form-control ml-3 w-auto" id="customerName" name="customerName" placeholder="Müşteri İsmi" readonly style="width: 200px;">
            <button class="btn btn-secondary ml-2" id="selectCustomer" data-toggle="modal" data-target="#customerModal">Müşteri Seç</button>
        </div>
<form class="forms-sample" action="<?= $_SERVER["PHP_SELF"]; ?>" method="post">
      

    <table class="table mt-4" id="dynamicTable">
        <thead>
            <tr>
                <th>Ürün Adı</th>
                <th>Adet</th>
                <th>Birim Fiyat</th>
                <th>Toplam Tutar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control product-select" name="productID[]">
                        <option value="">Seçin...</option>
                        <?php
                            $query = "SELECT * FROM products";
                            $selected_products = mysqli_query($connection, $query)-> fetch_all(MYSQLI_ASSOC);
                            foreach($selected_products as $product){
                        ?>
                        <option value="<?= $product["productID"]; ?>" data-price="<?= $product["unitPrice"]; ?>"><?= $product["productName"]; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control quantity" name="quantity[]">
                </td>
                <td>
                    <input type="text" class="form-control price" name="price[]" disabled>
                </td>
                <td>
                    <input type="text" class="form-control total" name="total[]" disabled>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Kaydet butonu -->
    <button type="submit" class="btn btn-success float-right mt-3">Kaydet</button>
</form>
<!-- Müşteri Seç Modal Dialog -->
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Müşteri Seç</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchCustomer" class="form-control mb-3" placeholder="Müşteri Arayın...">

                    <table class="table table-hover" id="customerTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>İsim</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) { ?>
                            <tr class="customer-row" data-id="<?= $user['user_id']; ?>" data-name="<?= $user['username']; ?>">
                                <td><?= $user['user_id']; ?></td>
                                <td><?= $user['name']; ?></td>
                                <td><?= $user['lastname']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

  </main>
  <!-- Navbar Ayarları -->
  <?php include "../includes/navbar_settings.php"; ?>
  <!--   Core JS Files   -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    var products = <?= json_encode($selected_products); ?>;

    $(document).ready(function() {
        // Yeni satır ekleme
        $('#addRow').click(function() {
            var newRow = `<tr>
                <td>
                    <select class="form-control product-select">
                        <option value="">Seçin...</option>`;
            products.forEach(function(product) {
                newRow += `<option value="${product.productID}" data-price="${product.unitPrice}">${product.productName}</option>`;
            });
            newRow += `</select>
                </td>
                <td><input type="number" class="form-control quantity" ></td>
                <td><input type="text" class="form-control price" disabled></td>
                <td><input type="text" class="form-control total" disabled></td>
            </tr>`;
            $('#dynamicTable tbody').append(newRow);
        });

        // Ürün seçimi ve fiyat güncelleme
        $(document).on('change', '.product-select', function() {
            var selectedOption = $(this).find('option:selected');
            var price = selectedOption.data('price');
            $(this).closest('tr').find('.quantity').prop(selectedOption.val() !== "");
            $(this).closest('tr').find('.price').val(price);
        });

        // Adet değiştiğinde toplam tutarı hesapla
        $(document).on('input', '.quantity', function() {
            var quantity = $(this).val();
            var price = $(this).closest('tr').find('.price').val();
            var total = quantity * price;
            $(this).closest('tr').find('.total').val(total.toFixed(2));
        });

        // Müşteri seçimi modalında arama
        $('#searchCustomer').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#customerTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Müşteri seçimi
        $(document).on('click', '.customer-row', function() {
            var customerName = $(this).data('name');
            $('#customerName').val(customerName);
            alert("kapan");
            $('#customerModal').modal('hide');
        });

        // Kaydetme işlemi
        $('#saveData').click(function() {
            alert("Veriler kaydedildi (şu anda sadece bir bildirim).");
        });
    });
</script>
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
 
  <script>
    $('#menu-firmalar').addClass('active bg-gradient-primary');
  </script>
</body>

</html>


