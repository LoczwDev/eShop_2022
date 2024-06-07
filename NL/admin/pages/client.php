<?php
session_start();
include_once('../../library/connect.php');

if (isset($_GET['login'])) {
  $outAcc = $_GET['login'];
} else {
  $outAcc = '';
}
?>
<?php
if (isset($_GET['quanly'])) {
  $client_id = $_GET['id'];

  if ($_GET['quanly'] == 'deleter_client') {
    $sql_deleter_client = mysqli_query($conn, "DELETE FROM client WHERE client_id = '$client_id'");
    $sql_account = mysqli_query($conn, "DELETE FROM account WHERE client_id = '$client_id'");
    // $sql_order = mysqli_query($conn, "DELETE order_list WHERE client_id = '$client_id'");
  } else if ($_GET['quanly'] == 'updatetype') {
    $sql_updateAcc = mysqli_query($conn, "UPDATE account SET user_type=1 WHERE client_id = '$client_id'");
  } else if ($_GET['quanly'] == 'resettype') {
    $sql_updateAcc = mysqli_query($conn, "UPDATE account SET user_type=2 WHERE client_id = '$client_id'");
  }

  header("Location: /NL/admin/pages/client.php");
}
if (isset($_POST["searchKeyword"])) {
  $searchKeyword = $_POST["searchKeyword"];

  // Câu truy vấn tìm kiếm
  $query = "SELECT * FROM account JOIN client ON account.client_id=client.client_id  WHERE user_email  LIKE '%$searchKeyword%' ORDER BY account.user_type ASC";
  $sql_client = mysqli_query($conn, $query);
} else {
  $sql_client = mysqli_query($conn,  "SELECT * FROM client JOIN account ON client.client_id = account.client_id ORDER BY account.user_type ASC");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="shortcut icon" href="../../upload/img/favicon.webp" type="image/x-icon">
  <title>
    Danh Sách Khách Hàng
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
          <a class="nav-link text-white" href="../pages/home.php">
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
          <a class="nav-link text-white active bg-gradient-primary" href="../pages/client.php">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Khách Hàng</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Khách Hàng</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <form class="ms-md-auto pe-md-3 " action="" method="post">
            <div class="d-flex align-items-center">
              <div class="input-group input-group-outline">
                <label class="form-label">Type here...</label>
                <input type="text" class="form-control" name="searchKeyword" onkeyup="this.form.submit()">
              </div>
            </div>
          </form>
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
        <div class="col-md-12 mx-auto">
          <div class="card mt-4">
            <div class="card-header p-3">
              <h5 class="mb-0">Danh Sách Tài Khoản</h5>
            </div>

            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tên Khách Hàng
                  </th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Số Điện
                    Thoại</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Địa Chỉ
                  </th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Loại Tài Khoản
                  </th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quản Lý
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                while ($row_client = mysqli_fetch_array($sql_client)) {
                  $i++;
                ?>
                  <tr>
                    <td class="align-middle text-center text-sm">
                      <div class="text-xs font-weight-bold">
                        <p>
                          <?php echo $i ?>
                        </p>
                      </div>
                    </td>
                    <td>
                      <div class="avatar-group mt-2">
                        <p class="font-weight-bolder text-lg">
                          <?php echo $row_client['client_name'] ?>
                        </p>
                      </div>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-lg  ml-2">
                        <?php echo $row_client['user_email'] ?>
                      </span>
                    </td>
                    <td class="align-middle text-center">
                      <div class="avatar-group mt-2">
                        <p>
                          <?php echo $row_client['client_phone'] ?>
                        </p>
                      </div>
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-lg  ml-2">
                        <?php echo $row_client['client_address'] ?>
                      </span>
                    </td>
                    <td class="align-middle text-center">
                      <?php
                      $userType = ($row_client['user_type'] == 0) ? 'Quản trị viên' : (($row_client['user_type'] == 1) ? 'Nhân viên' : 'Khách hàng');
                      ?>
                      <span class="text-lg font-weight-bolder ml-2 <?php echo ($row_client['user_type'] == 0) ? 'text-danger' : (($row_client['user_type'] == 1) ? 'text-info' : 'text-success') ?>">
                        <?php echo $userType; ?>
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <div class="progress-wrapper mx-auto d-flex justify-content-center gap-3">
                        <?php if ($row_client['user_type'] == 2) { ?>
                          <a href="?quanly=updatetype&id=<?php echo $row_client['client_id'] ?>" class="text-xs font-weight-bold">Cấp Quyền</a>
                        <?php } elseif ($row_client['user_type'] == 1) { ?>
                          <a href="?quanly=resettype&id=<?php echo $row_client['client_id'] ?>" class="text-xs font-weight-bold">Xóa Quyền</a>
                          <a href="?quanly=deleter_client&id=<?php echo $row_client['client_id'] ?>" class="text-xs font-weight-bold">Xóa</a>
                        <?php } else { ?>
                          <span class="text-lg font-weight-bold text-warning">Xếp Lớn</span>
                        <?php } ?>
                      </div>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
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
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>

</html>