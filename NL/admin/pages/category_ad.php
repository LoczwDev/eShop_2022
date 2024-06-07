<?php
session_start();
include_once('../../library/connect.php');

if (isset($_GET['login'])) {
  $outAcc = $_GET['login'];
} else {
  $outAcc = '';
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
    Danh Sách Danh Mục
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

        </script>
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary" href="../pages/category_ad.php">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Danh Mục</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Danh Mục</h6>
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
    <?php
    $sql_select = mysqli_query($conn, "SELECT * 
    FROM category_list ORDER BY category_id ASC");


    if (isset($_POST['add_category'])) {
      $typeCa_name_ad = $_POST['typeCa_name'];
      $category_id_ad = $_POST['category_id_ad'];
      $sql_insert = mysqli_query($conn, "INSERT INTO category_type(typeCa_name, category_id) values ('$typeCa_name_ad', '$category_id_ad')");
    } elseif (isset($_POST['update_category'])) {
      $typeCa_id = $_POST['typeCa_id'];
      $typeCa_name = $_POST['typeCa_name'];
      $category_id_ad = $_POST['category_id_ad'];
      $sql_edit = mysqli_query($conn, "UPDATE category_type 
      SET typeCa_name='$typeCa_name', category_id='$category_id_ad' WHERE typeCa_id='$typeCa_id'");

      if ($sql_edit) {
        echo '<script>window.location.href = "category_ad.php";</script>';
      }
    }
    ?>
    <div class="container-fluid py-4">
      <div class="row mb-4">
        <div class="col-lg-4 col-md-6">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <?php
                if (isset($_GET['quanly'])) {
                  $quanly = $_GET['quanly'];
                } else {
                  $quanly = '';
                }

                if ($quanly == 'update_ad') {
                  if (isset($_GET['id'])) {
                    $id_update = $_GET['id'];
                    $sql_update_ad = mysqli_query($conn, "SELECT * FROM category_type WHERE typeCa_id = '$id_update'");
                    $row_update_ad = mysqli_fetch_array($sql_update_ad);
                  }

                ?>
                  <div class="col-lg-6 col-7">
                    <h6>Cập Nhật Danh Mục</h6>
                    <form action="" method="post">
                      <select name="category_id_ad" class="form-select p-2 mb-3" aria-label="Default select example">
                        <option selected>Tên Danh Mục</option>
                        <?php
                        while ($row_select = mysqli_fetch_array($sql_select)) {
                          $selected = ($row_select['category_id'] == $row_update_ad['category_id']) ? 'selected' : '';
                        ?>
                          ?>
                          <option class="p-2" <?php echo $selected ?> value="<?php echo $row_select['category_id'] ?>"><?php echo $row_select['category_name'] ?></option>
                        <?php
                        }
                        ?>

                      </select>
                      <label for="">Tên Loại Danh Mục</label>
                      <input type="text" class="form-control" name="typeCa_name" placeholder="<?php echo $row_update_ad['typeCa_name'] ?>"><br>
                      <input type="hidden" class="form-control" name="typeCa_id" value="<?php echo $row_update_ad['typeCa_id']; ?>"><br>
                      <input class="btn btn-primary" type="submit" name="update_category" value="Cập Nhật Danh Mục"><br>
                    </form>
                  </div>
                <?php
                } elseif ($quanly == '') {
                ?>
                  <div class="col-lg-6 col-7">
                    <h6>Thêm Danh Mục</h6>
                    <form action="" method="post">
                      <select name="category_id_ad" class="form-select p-2 mb-3" aria-label="Default select example">
                        <option selected>Tên Danh Mục</option>
                        <?php
                        while ($row_select = mysqli_fetch_array($sql_select)) {
                        ?>
                          <option class="p-2" value="<?php echo $row_select['category_id'] ?>"><?php echo $row_select['category_name'] ?></option>
                        <?php
                        }
                        ?>

                      </select>
                      <label for="">Tên Loại Danh Mục</label>
                      <input type="text" class="form-control" name="typeCa_name" placeholder="Tên Loại Danh Mục"><br>
                      <input class="btn btn-primary" type="submit" name="add_category" value="Thêm Danh Mục"><br>
                    </form>
                  </div>
                <?php
                } elseif ($quanly == 'deleter_ad') {
                  if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql_deleter_ad = mysqli_query($conn, "DELETE FROM category_type WHERE typeCa_id = '$id'");
                    $sql_deleter_pr = mysqli_query($conn, "DELETE FROM product_list WHERE typeCa_id = '$id'");
                    if ($sql_deleter_ad) {
                      echo '<script>window.location.href = "category_ad.php";</script>';
                    }
                  }
                ?>
                <?php
                }
                ?>
              </div>
            </div>

          </div>
        </div>
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6>Danh Sách Danh Mục</h6>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <?php
                  $sql_category_ad = mysqli_query($conn, "SELECT * FROM category_list, category_type
                   WHERE category_list.category_id = category_type.category_id  ORDER BY category_list.category_id ASC");
                  ?>
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tên Danh Mục
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Loại
                        Danh Mục</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quản
                        Lý</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    while ($row_category_ad = mysqli_fetch_array($sql_category_ad)) {
                      $i++;
                    ?>
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <p><?php echo $i ?></p>
                          </div>
                        </td>
                        <td>
                          <div class="avatar-group mt-2">
                            <p><?php echo $row_category_ad['category_name'] ?></p>
                          </div>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="text-xs font-weight-bold"><?php echo $row_category_ad['typeCa_name'] ?></span>
                        </td>
                        <td class="align-middle">
                          <div class="progress-wrapper w-50 mx-auto d-flex justify-content-between">
                            <div class="progress-info">
                              <div class="progress-percentage">
                                <a href="?quanly=update_ad&id=<?php echo $row_category_ad['typeCa_id'] ?>" class="text-xs font-weight-bold">Cập Nhật</a>
                              </div>
                            </div>
                            <div class="">
                              <a href="?quanly=deleter_ad&id=<?php echo $row_category_ad['typeCa_id'] ?>" class="text-xs font-weight-bold">Xóa</a>
                            </div>
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
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>