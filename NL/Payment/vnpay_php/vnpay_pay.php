<?php
session_start();

include_once('../../library/connect.php');
$client_id = $_SESSION['user_id_client'];
$subtotal = $_SESSION['subtotal']; ?>

<?php 
$sql_client=mysqli_query($conn,"SELECT * FROM client WHERE client_id = '$client_id'");
$row_client = mysqli_fetch_array($sql_client);

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
    <title>Tạo mới đơn hàng</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="/NIENLUANCS/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">
    <script src="/NIENLUANCS/vnpay_php/assets/jquery-1.11.3.min.js"></script>
</head>

<body>
    <?php require_once("./config.php"); ?>
    <div class="container">
        <h3>Tạo mới đơn hàng</h3>
        <hr>
        <form action="/NL/Payment/vnpay_php/vnpay_create_payment.php" id="frmCreateOrder" method="post">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <span>
                            Số Tiền Cần Thanh Toán : <span style="font-size: 20px;" class="font-weight-bolder text-danger">
                                <?php echo number_format($subtotal, 0, '.', '.') . 'đ' ?>
                            </span>
                        </span>
                    </div>
                    <h4 class="text-primary">Thông Tin Giao Hàng</h4>
                    <div class="form-group">
                        <label for="amount">Tên Khách Hàng: </label>
                        <input class="form-control" placeholder="Nhập tên của bạn" name="name" type="text" value="<?php echo $row_client['client_name'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="amount">Số Điện Thoại: </label>
                        <input class="form-control" placeholder="Nhập số điện thoại" id="phone" name="phone" type="text" value="<?php echo $row_client['client_phone'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="amount">Địa Chỉ</label>
                        <input class="form-control" placeholder="Nhập Địa Chỉ" id="address" name="address" type="text" value="<?php echo $row_client['client_address'] ?>" />
                    </div>
                    <div class="form-group">
                        <label for="amount">Ghi Chú</label>
                        <textarea class="form-control" style="resize: none;" name="order_note" id="order_note" cols="62"
                            rows="5" placeholder="Ghi Chú"></textarea>
                    </div>
                </div>
                <div class="col-md-7">
                    <h4 class="text-primary">Chọn phương thức thanh toán</h4>
                    <div class="form-group">
                        <h5>Cách 1: Chuyển hướng sang Cổng VNPAY chọn phương thức thanh toán</h5>
                        <input type="radio" Checked="True" id="bankCode" name="bankCode" value="">
                        <label for="bankCode">Cổng thanh toán VNPAYQR</label><br>

                        <h5>Cách 2: Tách phương thức tại site của đơn vị kết nối</h5>
                        <input type="radio" id="bankCode" name="bankCode" value="VNPAYQR">
                        <label for="bankCode">Thanh toán bằng ứng dụng hỗ trợ VNPAYQR</label><br>

                        <input type="radio" id="bankCode" name="bankCode" value="VNBANK">
                        <label for="bankCode">Thanh toán qua thẻ ATM/Tài khoản nội địa</label><br>

                        <input type="radio" id="bankCode" name="bankCode" value="INTCARD">
                        <label for="bankCode">Thanh toán qua thẻ quốc tế</label><br>
                    </div>
                    <div class="form-group">
                        <h5>Chọn ngôn ngữ giao diện thanh toán:</h5>
                        <input type="radio" id="language" Checked="True" name="language" value="vn">
                        <label for="language">Tiếng việt</label><br>
                        <input type="radio" id="language" name="language" value="en">
                        <label for="language">Tiếng anh</label><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Thanh toán</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>