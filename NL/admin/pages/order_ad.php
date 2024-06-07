<?php
session_start();
include_once('../../library/connect.php');

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
<?php
if (isset($_POST['update_order'])) {
  $ma_order = $_POST['ma_order'];
  $order_status = isset($_POST['order_status']) ? 1 : 0;
  $sql_update_order = mysqli_query($conn, "UPDATE order_list SET order_status ='$order_status' WHERE ma_order = '$ma_order'");
  header("Location: order_ad.php");
} else if (isset($_POST["searchKeyword"])) {
  $searchKeyword = $_POST["searchKeyword"];

  // Câu truy vấn tìm kiếm
  $query = "SELECT *
  FROM order_list
  JOIN product_list ON product_list.product_id = order_list.product_id
  WHERE ma_order LIKE '%$searchKeyword%'
  ORDER BY order_id ASC";
  // $query = "SELECT * FROM order_list WHERE ma_order LIKE '%$searchKeyword%'";
  $sql_order = mysqli_query($conn, $query);
} else {
  $sql_order = mysqli_query($conn, 'SELECT * FROM order_list
  JOIN product_list ON product_list.product_id=order_list.product_id
   ORDER BY order_id ASC');
}
?>
<?php
if (isset($_GET["huydon"]) && isset($_GET['id'])) {
  $id_order = $_GET['id'];
  $xacnhanhuy = $_GET['huydon'];
} else {
  $xacnhanhuy = '';
  $id_order = '';
}

$sql_order_cancel = mysqli_query($conn, "UPDATE order_list SET order_cancel = '$xacnhanhuy' WHERE ma_order = '$id_order'");
?>
<?php
if (isset($_GET["quanly"]) && $_GET["quanly"] == 'deleter_order' && isset($_GET['id'])) {
  $id_deleter = $_GET["id"];
  // print_r($id_deleter);

  $sql_delter = mysqli_query($conn, "DELETE FROM order_list WHERE ma_order = '$id_deleter'");
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
    Danh Sách Đơn Hàng
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
          <a class="nav-link text-white active bg-gradient-primary" href="../pages/order_ad.php">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Đơn Hàng</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Đơn Hàng</h6>
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




    <div class="container-fluid">
      <div class="row justify-content-center">

        <div class="col-md-9">
          <div class="card">
            <div class="card-header pb-0 px-3">
              <h6 class="mb-0">Danh Sách Đơn Hàng</h6>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 container-table">
                <?php
                // $sql_order = mysqli_query($conn, 'SELECT * FROM order_list
                // JOIN product_list ON product_list.product_id=order_list.product_id
                // JOIN client ON client.client_id = order_list.client_id
                //  ORDER BY order_id ASC');
                ?>
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên Khách Hàng
                      </th>
                      <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">Thông Tin Sản Phẩm</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 w-15">Số Lượng</th> -->
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã Đơn
                        Hàng</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">Ngày
                        Đặt</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">Trạng
                        Thái Thanh Toán</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">Tình
                        Trạng</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">Quản
                        Lý</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $i = 0;
                    $maArray = [];
                    while ($row_order = mysqli_fetch_array($sql_order)) {
                      if (in_array($row_order['ma_order'], $maArray)) {
                        continue; // Bỏ qua và chuyển đến vòng lặp tiếp theo
                      }
                      $i++;
                      $maArray[] = $row_order['ma_order'];
                    ?>
                      <tr>
                        <td>
                          <div class="d-flex px-3 py-1">
                            <div class="d-flex fle  x-column justify-content-center">
                              <h6 class="mb-0 text-sm">
                                <?php echo $i ?>
                              </h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">
                                <?php echo $row_order['order_name'] ?>
                              </h6>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <div class="d-flex flex-column justify-content-center">
                            <?php echo $row_order['ma_order'] ?>
                          </div>
                        </td>
                        <td class="align-middle text-center">
                          <div class="d-flex flex-column justify-content-center">
                            <?php echo $row_order['order_date'] ?>
                          </div>
                        </td>
                        <td class="align-middle text-center">
                          <div class="d-flex flex-column justify-content-center">
                            <span class="<?php echo $row_order['payment_method'] == 4  ? 'text-danger' : 'text-primarty' ?>">
                              <?php echo $row_order['payment_method'] == 4 ? 'Chưa Thanh Toán' : 'Đã Thanh Toán' ?>
                            </span>
                          </div>
                        </td>
                        <td class="align-middle text-center">
                          <div class="d-flex flex-column justify-content-center">
                            <span class="fw-bold <?php echo $row_order['order_status'] == 1 ? 'text-success' : ($row_order['order_cancel'] == 1 ? 'text-danger' : '') ?>">
                              <?php
                              if ($row_order['order_cancel'] == 1) {
                                echo 'Đang Chờ Hủy Đơn';
                              } elseif ($row_order['order_cancel'] == 2) {
                                echo 'Đã Hủy Đơn';
                              } else {
                                echo $row_order['order_status'] == 1 ? 'Đã Xử Lý' : 'Chưa Xử Lý';
                              }
                              ?>
                            </span>
                          </div>
                        </td>
                        <td class="align-middle">
                          <div class="progress-wrapper mx-auto d-flex justify-content-center gap-3">
                            <div class="progress-info">
                              <div class="progress-percentage">
                                <?php if ($row_order['order_cancel'] == 1) { ?>
                                  <a href="?&id=<?php echo $row_order['ma_order'] ?>&huydon=2" class="text-xs font-weight-bold">Xác Nhận Hủy</a>
                                <?php } elseif ($row_order['order_cancel'] != 2) { ?>
                                  <a href="?quanly=order_view&id=<?php echo $row_order['ma_order'] ?>" class="text-xs font-weight-bold">Xem Đơn Hàng</a>
                                <?php } ?>
                              </div>
                            </div>
                            <?php if (($row_order['order_status'] === '1' || $row_order['order_cancel'] === '2')) { ?>
                              <div>
                                <a href="?quanly=deleter_order&id=<?php echo $row_order['ma_order'] ?>" class="text-xs font-weight-bold">Xóa</a>
                              </div>
                            <?php } ?>
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
        <?php if ((isset($_GET['quanly']) && $_GET['quanly'] == 'order_view')) {
          echo '<style>.col-md-9 { display: none; }</style>';
          if (isset($_GET['id'])) {
            $id_order = $_GET['id'];
          } ?>
          <div class="col-md-8">
            <form action="" method="post">
              <div class="card">
                <div class="card-header pb-0 px-3">
                  <h6 class="mb-0">Danh Sách Đơn Hàng</h6>
                </div>
                <div class="card-body px-0 pb-2">
                  <div class="table-responsive p-0 container-table">
                    <?php
                    $sql_view = mysqli_query($conn, "SELECT * FROM order_list
                  JOIN product_list ON product_list.product_id=order_list.product_id WHERE ma_order = '$id_order'");
                    ?>
                    <table class="table align-items-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">Thông Tin
                            Sản Phẩm</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Số
                            Lượng
                          </th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">Giá
                          </th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">Tạm
                            Tính</th>

                          <th class="text-secondary opacity-7"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 0;
                        $total_rice = 0;
                        while ($row_view = mysqli_fetch_array($sql_view)) {
                          $subTotal = $row_view['product_rice'] * $row_view['cart_quantity'];
                          $phone = $row_view['order_phone'];
                          $address = $row_view['order_address'];
                          $total_rice += $subTotal;
                          $i++;
                        ?>
                          <tr>
                            <td>
                              <div class="d-flex px-3 py-1">
                                <div class="d-flex fle  x-column justify-content-center">
                                  <h6 class="mb-0 text-sm">
                                    <?php echo $i ?>
                                  </h6>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                  <h6 class="mb-0 text-sm">
                                    <?php echo $row_view['product_name'] ?>
                                  </h6>
                                  <span>
                                    <?php echo $row_view['cart_size'] ?>
                                  </span>
                                  <p>
                                    <?php echo $row_view['product_color'] ?>
                                  </p>
                                </div>
                              </div>
                            </td>
                            <td class="align-middle text-center">
                              <div class="d-flex flex-column justify-content-center">
                                <?php echo $row_view['cart_quantity'] ?>
                              </div>
                            </td>
                            <td class="align-middle text-center">
                              <div class="d-flex flex-column justify-content-center">
                                <?php echo number_format($row_view['product_rice'], 0, '.', '.') . 'đ'; ?>
                              </div>
                            </td>
                            <td class="align-middle text-center">
                              <div class="d-flex flex-column justify-content-center">
                                <?php echo number_format($row_view['product_rice'] * $row_view['cart_quantity'], 0, '.', '.') . 'đ'; ?>
                              </div>
                            </td>
                            <input type="hidden" name="ma_order" value="<?php echo $id_order ?>">
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              <div class="card mt-4 mb-4">
                <div class="card-header p-3 pt-2">
                  <p>Thông Tin Địa Chỉ Đơn Hàng</p>
                  <div class="text-end pt-1 d-flex justify-content-end gap-2">
                    <span class="text-lg font-weight-bold">
                      <?php echo $address ?>
                    </span>
                  </div>
                  <p class="d-flex justify-content-end">SDT:
                    <?php echo $phone ?>
                  </p>
                </div>
              </div>
              <div class="card mt-4 mb-4">
                <div class="card-header p-3 pt-2">
                  <div class="icon w-30 d-flex justify-content-center icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl position-absolute">
                    <i class="opacity-10">Tổng Tiền</i>
                  </div>
                  <div class="text-end pt-1">
                    <h4 class="mb-0 text-danger">
                      <?php echo number_format($total_rice, 0, '.', '.') . 'đ'; ?>
                    </h4>
                  </div>
                </div>
              </div>
              <div class="d-flex gap-3 align-items-center justify-content-between mb-5">
                <?php
                $sql_order_status = mysqli_query($conn, "SELECT * FROM order_list WHERE ma_order='$id_order'");
                $row_order_status = mysqli_fetch_assoc($sql_order_status);

                ?>
                <a class="btn btn-secondary ms-2 mb-0" href="./order_ad.php">Quay về</a>
                <div class="d-flex align-items-center gap-2">
                  <?php if ($row_order_status['order_status'] !== '1') { ?>
                    <label style="font-size: 20px;" class="form-check " for="order_status_checkbox">
                      <input class="form-check-input" type="checkbox" id="order_status_checkbox" name="order_status" <?php echo $row_order_status['order_status'] == 1 ? 'checked' : '' ?>>Bàn Giao Vận Chuyển
                    </label>
                    <input class="btn btn-primary mb-0" type="submit" name="update_order" value="Cập Nhật Đơn Hàng">
                </div>
              <?php } else {
                    echo '
                  <span class= "text-danger text-lg">Đã Bàn Giao</span>';
                  } ?>


              </div>

            </form>
          </div>
        <?php } ?>
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

</html>