<?php
session_start();

include_once('../library/connect.php');

$subtotal = $_SESSION['subtotal'];
$client_id = $_SESSION['user_id_client'];

$client_name = $_SESSION['name'];
$client_phone = $_SESSION['phone'];
$client_address = $_SESSION['address'];
$order_note = $_SESSION['order_note'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Thanh Toán Thất Bại</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-primary">THÔNG TIN THANH TOÁN</h3>
        <div class="table-responsive">
            <div class="mb-2">
                <span class="font-weight-bolder">Thanh Toán Qua: </span>
                <span><?php echo $_SESSION['title'] ?></span>
            </div>
            <div class="mb-2">
                <span class="font-weight-bolder">Phương thức thanh toán: </span>
                <span>Thanh toán qua thẻ ATM/Tài khoản nội địa</span>
            </div>
            <div class="mb-2">
                <span class="font-weight-bolder">Số Tiền Thanh Toán: </span>
                <span class="text-danger h4 font-weight-bolder">
                    <?php echo number_format($subtotal, 0, '.', '.') . 'đ'  ?>
                </span>
            </div>
            <div class="mb-2">
                <span class="font-weight-bolder">Thông tin giao hàng:

                </span>
                <span> <?php echo $client_name . ', ' . $client_phone . ', ' . $client_address; ?></span>
                <p class="font-weight-bolder">Ghi Chú:
                    <span class="font-weight-normal"><?php echo $order_note ?></span>
                </p>

            </div>
            <div class="mb-2">
                <span class="font-weight-bolder">Người Nhận: Ivymoda</span>
            </div>
            <div class="mb-2">
                <span class="font-weight-bolder text-danger" style="font-size: 20px;">Thanh Toán Thất Bại</span>
            </div>
        </div>
        <a class="btn btn-primary" href="../index.php">Quay Lại</a>
    </div>
    </p>
    </div>
</body>

</html>