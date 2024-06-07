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
if (isset($_POST['add_product'])) {
  $product_name = $_POST['product_name'];
  $selected_option = $_POST['product_type'];
  list($typeCa_id, $category_id) = explode('|', $selected_option);

  // Lấy tên tệp tạm của ảnh 1
  $image1_tmp = $_FILES['image1']['tmp_name'];
  // Lấy tên tệp tạm của ảnh 2
  $image2_tmp = $_FILES['image2']['tmp_name'];
  $product_color = $_POST['product_color'];
  $product_rice = $_POST['product_rice'];
  $product_sizes = isset($_POST['product_size']) ? $_POST['product_size'] : '';
  $product_quantity = $_POST['quantity'];
  $is_new = isset($_POST['is_new']) ? 1 : 0;
  $mota = $_POST['mota'];
  $upload_directory = '../../upload/img/Product/';

  // Thực hiện thêm sản phẩm vào bảng product_list
  $sql_insert_product = mysqli_query($conn, "INSERT INTO product_list
  (category_id, product_name, product_rice, img1_product, img2_product, product_new, product_color, typeCa_id, mota)
   VALUES ('$category_id','$product_name','$product_rice', '$image1_tmp', '$image2_tmp', '$is_new', '$product_color', '$typeCa_id', '$mota')");

  if ($sql_insert_product) {
    $sql_select_product = "SELECT product_id FROM product_list WHERE product_name = '$product_name'";
    $result = mysqli_query($conn, $sql_select_product);
    $row_pr = mysqli_fetch_assoc($result);
    $product_id = $row_pr['product_id'];

    $image1_filename = $product_id . '_1.jpg';
    $image1_path = $upload_directory . $image1_filename;
    move_uploaded_file($image1_tmp, $image1_path);

    $image2_filename = $product_id . '_2.jpg';
    $image2_path = $upload_directory . $image2_filename;
    move_uploaded_file($image2_tmp, $image2_path);

    // Cập nhật tên ảnh trong cơ sở dữ liệu
    $sql_update_images = "UPDATE product_list 
    SET img1_product = '$image1_filename', img2_product = '$image2_filename' WHERE product_id = '$product_id'";
    mysqli_query($conn, $sql_update_images);

    // Thêm thông tin về size và số lượng vào bảng size_quantity
    for ($i = 0; $i < count($product_sizes); $i++) {
      $size_name = $product_sizes[$i];
      $size_quantity = $product_quantity[$i];
      $sql_insert_size = mysqli_query($conn, "INSERT INTO size_list (product_id, size_name, size_quantity) 
      VALUES ('$product_id', '$size_name', '$size_quantity')");
    }
    echo '<script>window.location.href = "product_ad.php";</script>';
  }
} elseif (isset($_POST['update_product'])) {
  $product_id = $_GET['id'];
  $product_name = $_POST['product_name'];
  $selected_option = $_POST['product_type'];
  list($typeCa_id, $category_id) = explode('|', $selected_option);
  $product_color = $_POST['product_color'];
  $mota = $_POST['mota'];
  $product_rice = $_POST['product_rice'];
  $product_sizes = $_POST['product_size'];
  $product_quantity = $_POST['quantity'];
  $is_new = isset($_POST['is_new']) ? 1 : 0;
  $upload_directory = '../../upload/img/Product/';

  // Kiểm tra nếu người dùng đã chọn ảnh mới
  if ($_FILES['image1']['error'] != 4) {
    $image1_tmp = $_FILES['image1']['tmp_name'];
    $image1_filename = $product_id . '_1.jpg';
    $image1_path = $upload_directory . $image1_filename;
    move_uploaded_file($image1_tmp, $image1_path);
    $sql_update_image1 = "UPDATE product_list SET img1_product = '$image1_filename' WHERE product_id = '$product_id'";
    mysqli_query($conn, $sql_update_image1);
  }

  if ($_FILES['image2']['error'] != 4) {
    $image2_tmp = $_FILES['image2']['tmp_name'];
    $image2_filename = $product_id . '_2.jpg';
    $image2_path = $upload_directory . $image2_filename;
    move_uploaded_file($image2_tmp, $image2_path);
    $sql_update_image2 = "UPDATE product_list SET img2_product = '$image2_filename' WHERE product_id = '$product_id'";
    mysqli_query($conn, $sql_update_image2);
  }

  // Cập nhật thông tin sản phẩm trong bảng product_list
  $sql_update_product = "UPDATE product_list SET category_id = '$category_id', product_name = '$product_name', 
    product_rice = '$product_rice', product_new = '$is_new', product_color = '$product_color', typeCa_id = '$typeCa_id' , mota = '$mota'
    WHERE product_id = '$product_id'";
  mysqli_query($conn, $sql_update_product);

  // Xóa thông tin về size và số lượng cũ trong bảng size_list
  $sql_delete_sizes = "DELETE FROM size_list WHERE product_id = '$product_id'";
  mysqli_query($conn, $sql_delete_sizes);

  // Thêm thông tin về size và số lượng mới vào bảng size_list
  for ($i = 0; $i < count($product_sizes); $i++) {
    $size_name = $product_sizes[$i];
    $size_quantity = $product_quantity[$i];
    $sql_insert_size = mysqli_query($conn, "INSERT INTO size_list (product_id, size_name, size_quantity) 
    VALUES ('$product_id', '$size_name', '$size_quantity')");
  }

  echo '<script>window.location.href = "product_ad.php";</script>';
}
?>
<?php
if (isset($_GET['quanly'])) {
  $quanly = $_GET['quanly'];
} else {
  $quanly = '';
}

if ($quanly == 'deleter_pr') {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_deleter_pr = mysqli_query($conn, "DELETE FROM product_list WHERE product_id ='$id'");
    $sql_delete_sizes = mysqli_query($conn, "DELETE FROM size_list WHERE product_id ='$id'");

    if ($sql_deleter_pr && $sql_delete_sizes) {
      $image1_path = '../../upload/img/Product/' . $id . '_1.jpg';
      if (file_exists($image1_path)) {
        unlink($image1_path); // Xóa ảnh 1 
      }

      $image2_path = '../../upload/img/Product/' . $id . '_2.jpg';
      if (file_exists($image2_path)) {
        unlink($image2_path); // Xóa ảnh 2
      }
      echo '<script>window.location.href = "product_ad.php";</script>';
    }
  }
}


if (isset($_POST["searchKeyword"])) {
  $searchKeyword = $_POST["searchKeyword"];

  // Câu truy vấn tìm kiếm
  $query = "SELECT * FROM product_list WHERE product_name LIKE '%$searchKeyword%'";
  $sql_product = mysqli_query($conn, $query);
} else {
  $sql_product = mysqli_query($conn, "SELECT * FROM product_list ORDER BY product_id ASC");
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
    Danh Sách Sản Phẩm
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
          <a class="nav-link text-white active bg-gradient-primary" href="../pages/product_ad.php">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Sản Phẩm</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Sản Phẩm</h6>
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
    <div class="container-fluid py-4">
      <div class="row display-product">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Danh Sách Sản Phẩm</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 container-table">
                <?php

                $sql_size_product = mysqli_query($conn, "SELECT * FROM product_list
                    JOIN size_list ON product_list.product_id = size_list.product_id ORDER BY product_list.product_id ASC");
                $output = [];
                while ($row = mysqli_fetch_array($sql_product, 1)) {
                  $output[] = $row;
                }
                $data = [];
                // print_r($output);


                foreach ($output as $row) {
                  $product_id = $row["product_id"];
                  $sql_size = mysqli_query($conn, "SELECT * FROM size_list WHERE product_id = '$product_id'");
                  $output_size = [];

                  while ($row_size = mysqli_fetch_assoc($sql_size)) {
                    $output_size[] = $row_size;
                  }
                  $typeCa_id = $row["typeCa_id"];
                  $sql_type = mysqli_query($conn, "SELECT typeCa_name FROM category_type WHERE typeCa_id = '$typeCa_id'");
                  $row_type = mysqli_fetch_assoc($sql_type);
                  $type_name = $row_type["typeCa_name"];



                  $data[] = [
                    'product_info' => $row,
                    'size' => $output_size,
                    'typeCa_name' => $type_name
                  ];
                }
                // print_r($data);




                ?>
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên Sản Phẩm</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">Loại Sản Phẩm
                      </th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 w-15">Ảnh Sản Phẩm
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Màu
                        Sắc</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">Giá
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Size &
                        Số Lượng</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sản
                        Phẩm Mới</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quản
                        Lý</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach ($data as $row) :
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
                                <?php echo $row['product_info']['product_name'] ?>
                              </h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">
                                <?php echo $row['typeCa_name'] ?>
                              </h6>
                            </div>
                          </div>
                        </td>
                        <td class="d-flex">
                          <div class="d-flex px-3 py-1">
                            <div class="d-flex flex-column justify-content-center ">
                              <img class="w-100" src="../../upload/img/Product/<?php echo $row['product_info']['img1_product'] ?>" alt="">
                            </div>
                          </div>
                          <div class="d-flex px-3 py-1">
                            <div class="d-flex flex-column justify-content-center ">
                              <img class="w-100" src="../../upload/img/Product/<?php echo $row['product_info']['img2_product'] ?>" alt="">
                            </div>
                          </div>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="badge badge-sm bg-gradient-success">
                            <?php echo $row['product_info']['product_color'] ?>
                          </span>
                        </td>
                        <td class="align-middle text-center">
                          <span class="text-secondary text-lg font-weight-bold">
                            <?php echo number_format($row['product_info']['product_rice'], 0, '.', '.') . 'đ'; ?>
                          </span>
                        </td>

                        <td class="align-middle text-center">
                          <select class="form-select p-2" aria-label="Default select example">
                            <option selected disabled>Size Và Số Lượng Sản Phẩm</option>
                            <?php if (!empty($row['size'])) : ?>
                              <?php foreach ($row['size'] as $select_size) : ?>
                                <option value="<?php echo $select_size['size_id'] ?>">
                                  <?php echo $select_size['size_name'] ?>, Số Lượng:
                                  <?php echo $select_size['size_quantity'] ?>
                                </option>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </select>
                        </td>

                        <td class="align-middle text-center">
                          <span class="<?php echo $row['product_info']['product_new'] == 1 ? 'text-danger' : 'text-success'; ?> text-md font-weight-bold">
                            <?php echo $row['product_info']['product_new'] == 1 ? 'SP.Mới' : 'SP.Cũ'; ?>
                          </span>
                        </td>
                        <td class="align-middle">
                          <div class="progress-wrapper mx-auto d-flex justify-content-center gap-3">
                            <div class="progress-info">
                              <div class="progress-percentage">
                                <a href="?quanly=update_pr&id=<?php echo $row['product_info']['product_id'] ?>" class="text-xs font-weight-bold">Cập Nhật</a>
                              </div>
                            </div>
                            <div class="">
                              <a href="?quanly=deleter_pr&id=<?php echo $row['product_info']['product_id'] ?>" class="text-xs font-weight-bold">Xóa</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                    <?php
                    endforeach; ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if ($quanly == '') { ?>
        <div class="btn btn-primary w-15 d-flex justify-content-center ml-auto" style="margin-left: auto;">
          <a style="color: #fff;" href="?quanly=add_product_ad">Thêm Sản Phẩm</a>
        </div>
      <?php } ?>

      <div class="row">
        <div class="col-12">
          <?php
          if ($quanly == 'add_product_ad') {
            echo '<style>.display-product{display: none}</style>';

          ?>
            <form action="" method="post" enctype="multipart/form-data">
              <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                  <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Thêm Sản Phẩm</h6>
                  </div>
                </div>
                <div class="card-body px-0 pb-2">
                  <div class="table-responsive p-0">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-4 border-right">
                          <h4>
                            Thông tin cơ bản của sản phẩm
                          </h4>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="product_name">Tên Sản Phẩm:</label>
                            <input class="rounded p-1 border-1" type="text" id="product_name" name="product_name" required placeholder="Nhập Tên Sản Phẩm">
                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="product_type">Loại Sản Phẩm:</label>
                            <?php
                            $sql_add_type = mysqli_query($conn, "SELECT * FROM category_type JOIN category_list ON category_type.category_id=category_list.category_id ORDER BY typeCa_id ASC");
                            ?>
                            <select class="p-2" id="product_type" name="product_type" required>
                              <option selected>Chọn Loại Sản Phẩm</option>
                              <?php
                              while ($row_add_type = mysqli_fetch_array($sql_add_type)) {
                              ?>
                                <option value="<?php echo $row_add_type['typeCa_id'] ?>|<?php echo $row_add_type['category_id'] ?>">
                                  <?php echo $row_add_type['typeCa_name'] ?>,
                                  <?php echo $row_add_type['category_name'] ?>
                                </option>
                              <?php
                              } ?>
                            </select>
                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="product_color">Màu Sắc:</label>
                            <input class="rounded p-1 border-1" type="text" id="product_color" name="product_color" placeholder="Nhập Màu" required>
                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="product_rice">Giá:</label>
                            <input class="rounded p-1 border-1" type="number" id="product_rice" name="product_rice" placeholder="Nhập Giá" required>
                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="is_new">Mô Tả Sản Phẩm: </label>
                            <div class="form-check is-filled">
                              <textarea style="resize: none;" name="mota" id="" cols="30" rows="10" required></textarea>
                            </div>

                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="is_new">Sản Phẩm Mới:</label>
                            <div class="form-check is-filled">
                              <input class="form-check-input" type="checkbox" name="is_new" value="1">
                            </div>

                          </div>

                        </div>
                        <div class="col-md-5 border-right">
                          <h4>Ảnh Sản phẩm</h4>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="image1">Ảnh 1:</label>
                            <input type="file" id="image1" name="image1" accept="image/*" required>

                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="image2">Ảnh 2:</label>
                            <input type="file" id="image2" name="image2" accept="image/*" required>

                          </div>
                          <div class="d-flex w-100">
                            <img id="selectedImage1" class="mt-3 img-fluid hidden  w-50" src="" alt="Ảnh được chọn">
                            <img id="selectedImage2" class="mt-3 img-fluid hidden  w-50" src="" alt="Ảnh được chọn">
                          </div>

                        </div>
                        <div class="col-md-3">
                          <h4>Thông tin size sản phẩm</h4>
                          <div class="form-check check-size mb-2">
                            <input checked class="form-check-input m-0" type="checkbox" name="product_size[]" value="S">
                            <label class="form-check-label m-0" for="size_s">S</label>
                            <input class="rounded p-1 border-1" type="number" name="quantity[]" placeholder="Số lượng" min="0">
                          </div>

                          <div class="form-check check-size mb-2">
                            <input checked class="form-check-input m-0" type="checkbox" name="product_size[]" value="M">
                            <label class="form-check-label m-0" for="size_m">M</label>
                            <input class="rounded p-1 border-1" type="number" name="quantity[]" placeholder="Số lượng" min="0">
                          </div>

                          <div class="form-check check-size mb-2">
                            <input checked class="form-check-input m-0" type="checkbox" name="product_size[]" value="L">
                            <label class="form-check-label m-0" for="size_l">L</label>
                            <input class="rounded p-1 border-1" type="number" name="quantity[]" placeholder="Số lượng" min="0">
                          </div>

                          <div class="form-check check-size mb-2">
                            <input checked class="form-check-input m-0" type="checkbox" name="product_size[]" value="XL">
                            <label class="form-check-label m-0" for="size_xl">XL</label>
                            <input class="rounded p-1 border-1" type="number" name="quantity[]" placeholder="Số lượng" min="0">
                          </div>

                          <div class="form-check check-size mb-2">
                            <input checked class="form-check-input m-0" type="checkbox" name="product_size[]" value="XXL">
                            <label class="form-check-label m-0" for="size_xxl">XXL</label>
                            <input class="rounded p-1 border-1" type="number" name="quantity[]" placeholder="Số lượng" min="0">
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-lg-11 col-12 d-flex justify-content-end">
                  <input class="btn btn-primary" type="submit" name="add_product" value="Thêm Sản Phẩm"><br>
                </div>
                <div class="col-lg-11 col-12 d-flex justify-content-end">
                  <input class="btn btn-secondary ms-2" type="button" value="Quay lại" onclick="history.back()">
                </div>
            </form>
          <?php
          } elseif ($quanly == 'update_pr') {
            echo '<style>.display-product{display: none}</style>';
            $id_update = $_GET['id'];
            $sql_update_pr = mysqli_query($conn, "SELECT * FROM product_list WHERE product_id ='$id_update'");
            $row_update_pr = mysqli_fetch_array($sql_update_pr);

          ?>

            <form action="" method="post" enctype="multipart/form-data">
              <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                  <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Cập Nhật Sản Phẩm</h6>
                  </div>
                </div>
                <div class="card-body px-0 pb-2">
                  <div class="table-responsive p-0">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-4 border-right">
                          <h4>
                            Thông tin cơ bản của sản phẩm
                          </h4>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="product_name">Tên Sản Phẩm:</label>
                            <input class="rounded p-1 border-1" type="text" id="product_name" name="product_name" required value="<?php echo $row_update_pr['product_name'] ?>">
                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="product_type">Loại Sản Phẩm:</label>
                            <?php
                            $sql_add_type = mysqli_query($conn, "SELECT * FROM category_type JOIN category_list ON category_type.category_id=category_list.category_id ORDER BY typeCa_id ASC");
                            ?>
                            <select class="p-2" id="product_type" name="product_type" required>
                              <option>Chọn Loại Sản Phẩm</option>
                              <?php
                              while ($row_add_type = mysqli_fetch_array($sql_add_type)) {
                                $selected = ($row_add_type['typeCa_id'] == $row_update_pr['typeCa_id']) ? 'selected' : '';
                              ?>
                                <option <?php echo $selected ?> value="<?php echo $row_add_type['typeCa_id'] ?>|<?php echo $row_add_type['category_id'] ?>">
                                  <?php echo $row_add_type['typeCa_name'] ?>,
                                  <?php echo $row_add_type['category_name'] ?>
                                </option>

                              <?php
                              } ?>
                            </select>
                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="product_color">Màu Sắc:</label>
                            <input class="rounded p-1 border-1" type="text" id="product_color" name="product_color" value="<?php echo $row_update_pr['product_color'] ?>" required>
                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="product_rice">Giá:</label>
                            <input class="rounded p-1 border-1" type="number" id="product_rice" name="product_rice" value="<?php echo $row_update_pr['product_rice'] ?>" required>
                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="is_new">Mô Tả Sản Phẩm: </label>
                            <div class="form-check is-filled">
                              <textarea style="resize: none;" name="mota" id="" cols="30" rows="10" required><?php echo $row_update_pr['mota'] ?></textarea>
                            </div>

                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="is_new">Sản Phẩm Mới:</label>
                            <div class="form-check is-filled">
                              <input class="form-check-input" <?php echo ($row_update_pr['product_new'] == 1) ? 'checked' : ''; ?> type="checkbox" name="is_new">
                            </div>

                          </div>

                        </div>
                        <div class="col-md-5 border-right">
                          <h4>Ảnh Sản phẩm</h4>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="image1">Ảnh 1:</label>
                            <input type="file" id="image1" name="image1" accept="image/*">

                          </div>
                          <div class="d-flex justify-content-between mb-3">
                            <label for="image2">Ảnh 2:</label>
                            <input type="file" id="image2" name="image2" accept="image/*">

                          </div>
                          <div class="d-flex w-100">
                            <img id="selectedImage1" class="mt-3 img-fluid <?php echo isset($_POST['update_pr']) ? 'hidden' : '' ?> w-50" src="../../upload/img/Product/<?php echo $row_update_pr['img1_product'] ?>" alt="Ảnh được chọn">
                            <img id="selectedImage2" class="mt-3 img-fluid <?php echo isset($_POST['update_pr']) ? 'hidden' : '' ?> w-50" src="../../upload/img/Product/<?php echo $row_update_pr['img2_product'] ?>" alt="Ảnh được chọn">
                          </div>

                        </div>
                        <div class="col-md-3">
                          <h4>Thông tin size sản phẩm</h4>
                          <?php
                          // Danh sách các kích thước bạn muốn hiển thị
                          $sizes = ['S', 'M', 'L', 'XL', 'XXL'];

                          foreach ($sizes as $size) {
                            $quantity = 0; // Giá trị mặc định cho số lượng

                            // Kiểm tra xem kích thước có sẵn trong cơ sở dữ liệu không
                            $sql_size = mysqli_query($conn, "SELECT * FROM size_list WHERE product_id = '$id_update' AND size_name = '$size'");
                            $row_size = mysqli_fetch_assoc($sql_size);
                            if ($row_size) {
                              $quantity = $row_size['size_quantity']; // Nếu có, đặt giá trị số lượng từ cơ sở dữ liệu
                            }
                          ?>

                            <div class="form-check check-size mb-2">
                              <input class="form-check-input m-0" type="checkbox" checked name="product_size[]" value="<?php echo $size; ?>">
                              <label class="form-check-label m-0" for="size_<?php echo $size; ?>"><?php echo $size; ?></label>
                              <input class="rounded p-1 border-1" type="number" name="quantity[]" value="<?php echo $quantity; ?>" min="0">
                            </div>

                          <?php
                          }
                          ?>

                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-11 col-12 d-flex justify-content-end">
                  <input class="btn btn-primary" type="submit" name="update_product" value="Cập Nhật Sản Phẩm"><br>
                </div>
                <div class="col-lg-11 col-12 d-flex justify-content-end">
                  <input class="btn btn-secondary ms-2" type="button" value="Quay lại" onclick="history.back()">
                </div>
              </div>
            </form>

          <?php } ?>
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
</body>

</html>
<script>
  const image1Input = document.getElementById('image1');
  const image2Input = document.getElementById('image2');
  const selectedImage1 = document.getElementById('selectedImage1');
  const selectedImage2 = document.getElementById('selectedImage2');

  image1Input.addEventListener('change', (event) => {
    displaySelectedImage(event, selectedImage1);
  });

  image2Input.addEventListener('change', (event) => {
    displaySelectedImage(event, selectedImage2);
  });

  function displaySelectedImage(event, imageElement) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        imageElement.src = e.target.result;
        imageElement.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    } else {
      imageElement.src = '';
      imageElement.classList.add('hidden');
    }
  }
</script>