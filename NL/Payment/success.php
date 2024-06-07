<?php
session_start();

include_once('../library/connect.php');

$subtotal = $_SESSION['subtotal'];
$client_id = $_SESSION['user_id_client']; ?>


<?php
if (isset($_GET['vnp_TransactionStatus']) && $_GET['vnp_TransactionStatus'] == 0) {
    $title = 'VNpay';
} else if (isset($_GET['message']) && $_GET['message'] == 'Successful.') {
    $title = 'ATMMOMO';
}
if ((isset($_GET['vnp_TransactionStatus']) && $_GET['vnp_TransactionStatus'] == 0) || (isset($_GET['message']) && $_GET['message'] == 'Successful.')) {
    if (isset($_GET['vnp_Amount']) || isset($_GET['amount'])) {
        $client_name = $_SESSION['name'];
        $client_phone = $_SESSION['phone'];
        $client_address = $_SESSION['address'];
        $order_note = $_SESSION['order_note'];

    //     $sql_update_client = mysqli_query($conn, "UPDATE client 
    // SET client_name = '$client_name', client_phone = '$client_phone', client_address = '$client_address' WHERE client_id = '$client_id'");


        $payment_method = isset($_GET['vnp_TransactionStatus']) ? '1' : '2';
        $ma_order = rand(0, 9999);

        // Lấy danh sách sản phẩm trong giỏ hàng
        $sql_get_cart = mysqli_query($conn, 'SELECT * FROM cart_list ORDER BY cart_id ASC');

        while ($row_get_cart = mysqli_fetch_array($sql_get_cart)) {
            $product_id = $row_get_cart['product_id'];
            $cart_quantity = $row_get_cart['cart_quantity'];
            $cart_size = $row_get_cart['cart_size'];
            $order_date = date('Y-m-d H:i:s');

            // Insert thông tin đơn hàng vào bảng "order_list"
            $sql_order = mysqli_query($conn, "INSERT INTO order_list (client_id, product_id, cart_quantity, ma_order, order_date, cart_size, payment_method, order_note, order_name, order_phone, order_address) VALUES
            ('$client_id', '$product_id', '$cart_quantity', '$ma_order', '$order_date', '$cart_size','$payment_method', '$order_note', '$client_name', '$client_phone', '$client_address')");
            // Xóa các sản phẩm trong giỏ hàng
            $sqli_update_quantity = mysqli_query($conn, "UPDATE size_list SET size_quantity = size_quantity - '$cart_quantity' WHERE product_id = '$product_id' AND size_name = '$cart_size'");


            $sql_delete_cart = mysqli_query($conn, "DELETE FROM cart_list WHERE product_id='$product_id'");
        }
    }
} else {
    if (isset($_GET['vnp_TransactionStatus']) && $_GET['vnp_TransactionStatus'] !== 0) {
        $title = 'VNpay';
        $_SESSION['title'] = $title;
    } else if (isset($_GET['message']) && $_GET['message'] !== 'Successful.') {
        $title = 'ATMMOMO';
        $_SESSION['title'] = $title;
    }
    header("Location: http://localhost/NL/Payment/cancel.php");
}

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
    <title>Thanh Toán Thành Công</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
</head>

<body>
    <div class="container mt-5">
        <h3 class="text-primary">THÔNG TIN THANH TOÁN</h3>
        <div class="table-responsive">
            <div class="mb-2">
                <span class="font-weight-bolder">Thanh Toán Qua: </span>
                <span><?php echo $title ?></span>
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
                <span class="font-weight-bolder text-success" style="font-size: 20px;">Thanh Toán Thành Công</span>
            </div>
        </div>
        <a class="btn btn-primary" href="../index.php">Quay Lại</a>
    </div>
    </p>
    </div>
</body>

</html>