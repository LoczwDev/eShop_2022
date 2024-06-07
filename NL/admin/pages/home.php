<?php
session_start();
include_once('../../library/connect.php');
if (!isset($_SESSION['login'])) {
  header('Location: dangnhap.php');
}
if (isset($_GET['login'])) {
  $outAcc = $_GET['login'];
} else {
  $outAcc = '';
}
// if ($outAcc == 'out') {
//   session_destroy();
//   header('Location: ../../index.php');
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="shortcut icon" href="../../upload/img/favicon.webp" type="image/x-icon">
  <title>
    Trang Chủ Admin
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
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/admin.css">
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary" href="../pages/home.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">home</i>
            </div>
            <span class="nav-link-text ms-1">Trang Chủ</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="../pages/category_ad.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">category</i>
            </div>
            <span class="nav-link-text ms-1">Danh Mục</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="../pages/product_ad.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">checkroom</i>
            </div>
            <span class="nav-link-text ms-1">Sản Phẩm</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="../pages/order_ad.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">local_shipping</i>
            </div>
            <span class="nav-link-text ms-1">Đơn Hàng</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="../pages/client.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">groups</i>
            </div>
            <span class="nav-link-text ms-1">Tài Khoản</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
        </li>
        <?php
        if ($outAcc == 'out') {
          echo '
          <script>
          Swal.fire("Thành Công", "Đăng Xuất Thành Công", "success").then(function() {
              window.location.href = "../../index.php";
          });
      </script>';
        }

        ?>
        <li class="nav-item">
          <a class="nav-link text-white " href="?login=out">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">logout</i>
            </div>
            <span class="nav-link-text ms-1">Đăng Xuất</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Trang Chủ</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Trang Chủ</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="" class="nav-link text-body font-weight-bold px-0">
                <span class="admin_name d-sm-inline d-none">
                  <?php echo $_SESSION['login'] ?>
                </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <?php $sql_product = mysqli_query($conn, 'SELECT * FROM product_list');
          $total_products = mysqli_num_rows($sql_product);
          ?>
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">checkroom</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Sản Phẩm</p>
                <h4 class="mb-0 text-warning"><?php echo $total_products ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <?php $sql_order = mysqli_query($conn, 'SELECT COUNT(DISTINCT ma_order) AS total_order FROM order_list');
          $row_order = mysqli_fetch_assoc($sql_order);
          $total_order = $row_order['total_order'];
          ?>
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">local_shipping</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Số Đơn Hàng Mới</p>
                <h4 class="mb-0 text-primary"><?php echo $total_order ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than last month</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <?php $sql_client = mysqli_query($conn, 'SELECT * FROM client');
          $total_client = mysqli_num_rows($sql_client);
          ?>
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Số Khách Hàng Hiện Tại</p>
                <h4 class="mb-0 text-danger"><?php echo $total_client ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> than yesterday</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <?php
          $sql_rice = "SELECT SUM(order_list.cart_quantity * product_list.product_rice) AS total_rice FROM order_list 
              JOIN product_list ON order_list.product_id = product_list.product_id WHERE payment_method != '4'";
          $result = mysqli_query($conn, $sql_rice);
          $row_rice = mysqli_fetch_assoc($result);
          $total_rice = isset($row_rice['total_rice']) ? $row_rice['total_rice'] : '0';
          ?>
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">savings</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Tổng Doanh Thu Đạt Được</p>
                <h4 class="mb-0 text-success"><?php echo number_format($total_rice, 0, '.', '.') . 'đ'; ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday</p>
            </div>
          </div>
        </div>
      </div>
      <?php
      // Thực hiện câu truy vấn để lấy số lượng đơn hàng qua ngày
      $sql_char = mysqli_query($conn, 'SELECT DATE((order_date)) AS ngay, COUNT(*) AS so_luong_don_hang FROM order_list GROUP BY DATE((order_date))');
      $order_data = array();
      while ($row_char = mysqli_fetch_assoc($sql_char)) {
        $order_data[] = $row_char;
      }
      // print_r($order_data);
      ?>
      <div class="mt-1 w-50">
        <canvas id="revenueChart"></canvas>
      </div>
    </div>

  </main>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script>
    var orderData = <?php echo json_encode($order_data); ?>;

    // Lấy tham chiếu đến thẻ canvas trong HTML
    var ctx = document.getElementById('revenueChart').getContext('2d');

    // Tạo biểu đồ đường
    var orderChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: orderData.map(data => data.ngay),
        datasets: [{
          label: 'Tổng đơn hàng',
          data: orderData.map(data => data.so_luong_don_hang),
          borderColor: 'rgb(255, 20, 147)',
          fill: false
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>