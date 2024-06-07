<?php
session_start();

include_once('../../library/connect.php');
$client_id = $_SESSION['user_id_client'];
$subtotal = $_SESSION['subtotal']; ?>

<?php
$sql_client = mysqli_query($conn, "SELECT * FROM client WHERE client_id = '$client_id'");
$row_client = mysqli_fetch_array($sql_client);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Qua MoMo</title>
    <link rel="shortcut icon" href="./assets/img/favicon.webp" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="./assets/css/main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.green.min.css" integrity="sha512-C8Movfk6DU/H5PzarG0+Dv9MA9IZzvmQpO/3cIlGIflmtY3vIud07myMu4M/NTPJl8jmZtt/4mC9bAioMZBBdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-notify@0.2.0/dist/css/bootstrap-notify.min.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h3>Tạo mới đơn hàng</h3>
        <hr>
        <form id="atm-MOMO" class="" name="form_momoATM" method="POST"  action="/NL/Payment/MoMo/atm_momo.php">
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
                        <textarea class="form-control" style="resize: none;" name="order_note" id="order_note" cols="62" rows="5" placeholder="Ghi Chú"></textarea>
                    </div>
                </div>
                <div class="col-md-7">
                    <h4 class="text-primary">
                        <Param>
                        </Param>Phương thức thanh toán
                    </h4>
                    <div class="form-group">
                        <h5>Chuyển hướng sang Cổng Thanh Toán MoMo</h5>
                        <input type="radio" Checked="True" value="">
                        <label for="bankCode">Cổng thanh toán ATM_MoMo</label><br>
                    </div>
                    <button type="submit" class="btn btn-primary">Thanh toán</button>
                </div>
            </div>
        </form>
    </div>
</body>


</html>