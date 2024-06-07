<?php if (isset($_GET['huydon']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $huydon = $_GET['huydon'];
} else {
    $id = '';
    $huydon = '';
}
$sql_order_cancel = mysqli_query($conn, "UPDATE order_list SET order_cancel = '$huydon' WHERE ma_order = '$id'");

?>
<?php
if (isset($_POST['delete_orders'])) {
    $selectedOrders = $_POST['selected_orders'];
    foreach ($selectedOrders as $orderId) {
        // Thực hiện truy vấn SQL để xóa đơn hàng với mã là $orderId
        $sql_delete_order = mysqli_query($conn, "DELETE FROM order_list WHERE ma_order = '$orderId'");
        // Kiểm tra và thông báo xóa thành công hoặc không thành công
    }
}

?>

<main>
    <?php $client_id = $_SESSION['user_id_client']; ?>
    <div class="row order-display" style="margin: 0; justify-content: space-between; ">
        <div class="mb-5 py-3 bg-white rounded left-info" style="width: 330px; height: 100%;">
            <ul>
                <li><a href="index.php?quanly=infoclient">Tài khoản</a></li>
                <li><a class="active" href="index.php?quanly=processing">Đơn hàng đang xử lý</a></li>
                <li><a href="index.php?quanly=changepass">Đổi Mật Khẩu</a></li>
                <li><a onclick="handleLogout(event)" href="">Đăng xuất</a></li>
            </ul>
        </div>
        <div class="p-3 mb-5 py-3 bg-white rounded  right-info" style="width: 1150px; height: 100%;">
            <form method="post" action="" onsubmit="return validateForm()">
                <?php $sql_order = mysqli_query($conn, "SELECT * FROM order_list WHERE client_id = '$client_id'"); ?>
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Mã
                                Đơn
                                Hàng</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">
                                Ngày
                                Đặt</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">
                                Trạng
                                Thái Thanh Toán</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">
                                Tình
                                Trạng</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacixty-7">
                                Quản
                                Lý</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $i = 0;
                        $arr = [];
                        while ($row_order = mysqli_fetch_array($sql_order)) {
                            if (in_array($row_order['ma_order'], $arr)) {
                                continue; // Bỏ qua và chuyển đến vòng lặp tiếp theo
                            }
                            $arr[] = $row_order['ma_order'];
                            $i++;
                        ?>
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex fle  x-column justify-content-center">
                                            <input type="checkbox" <?php echo ($row_order['order_status'] === '1' || $row_order['payment_method'] != 4) ? ' disabled' : ''; ?> name="selected_orders[]" value="<?php echo $row_order['ma_order']; ?>">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex fle  x-column justify-content-center">
                                            <h6 class="mb-0 text-sm">
                                                <?php echo $i ?>
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
                                        <span class="<?php echo $row_order['payment_method'] == 4 ? 'text-danger' : 'text-primarty' ?>">
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
                                                echo '<span class="font-weight-bolder text-danger">Đã Hủy</span>';
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
                                                <a href="?quanly=order_client_view&id=<?php echo $row_order['ma_order'] ?>" class="text-xs font-weight-bold">Xem Chi Tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="7" class="text-center text-danger">
                                <span style="font-size: 25px;">
                                    <?php echo ($i == 0) ? 'Bạn Không Có Đơn Hàng Nòa' : '' ?>
                                </span>
                            </td>

                        </tr>
                    </tbody>
                </table>
                <?php
                if (mysqli_num_rows($sql_order) !== 0) { ?>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" name="delete_orders">Xoá Hàng Loạt</button>
                    </div>
                <?php } ?>

            </form>

        </div>
    </div>
    <?php if (isset($_GET['quanly']) && $_GET['quanly'] == 'order_client_view') {
        echo '<style>.order-display { display: none; }</style>';
        if (isset($_GET['id'])) {
            $id_order = $_GET['id'];
            $sql_view = mysqli_query($conn, "SELECT * FROM order_list
            JOIN product_list ON product_list.product_id=order_list.product_id WHERE ma_order = '$id_order'");
            $row_left_order = mysqli_fetch_assoc($sql_view);


            $sql_order_detail = mysqli_query($conn, "SELECT * FROM order_list
            JOIN product_list ON product_list.product_id=order_list.product_id WHERE ma_order = '$id_order'");
        } ?>
        <div class="checkout-process-bar block-border mb-5">
            <ul>
                <li class="active"><span>Giỏ hàng </span></li>
                <li class="active"><span>Đặt hàng</span></li>
                <li class="<?php echo $row_left_order['payment_method'] == 4 ? '' : 'active' ?>"><span>Thanh toán</span></li>
                <li><span>Hoàn thành đơn</span></li>
            </ul>
            <p class="checkout-process-bar__title">Giỏ hàng</p>
        </div>
        <form class="row" style="margin: 0;" action="" method="post">
            <div class="col-md-7 border-right">
                <h2 class="font-weight-bold text-lg">Thông Tin Khách Hàng</h2>
                <div class="border rounded p-3">
                    <div class="border-bottom">
                        <div class="d-flex w-75 align-items-center my-3 justify-content-between">
                            <span>Tên Khách Hàng: </span>
                            <span class="font-weight-bold">
                                <?php echo $row_left_order['order_name'] ?>
                            </span>
                        </div>

                    </div>
                    <div class="border-bottom">
                        <div class="d-flex w-75 align-items-center my-3 justify-content-between">
                            <span>Số Điện Thoại: </span>
                            <span class="font-weight-bold">
                                <?php echo $row_left_order['order_phone'] ?>
                            </span>
                        </div>

                    </div>
                    <div class="border-bottom">
                        <div class="d-flex w-75 align-items-center my-3 justify-content-between">
                            <span>Địa Chỉ: </span>
                            <span class="font-weight-bold">
                                <?php echo $row_left_order['order_address'] ?>
                            </span>
                        </div>

                    </div>
                    <div class="border-bottom">
                        <div class="d-flex w-75 align-items-center my-3 justify-content-between">
                            <span>Ghi Chú: </span>
                            <span class="font-weight-bold">
                                <?php echo $row_left_order['order_note'] ?>
                            </span>
                        </div>

                    </div>
                    <div class="">
                        <div class="d-flex w-75 align-items-center my-3 justify-content-between">
                            <span>Phương Thức Thanh Toán: </span>
                            <span class="font-weight-bold">
                                <?php
                                $paymentMethod = $row_left_order['payment_method'];
                                if ($paymentMethod == 1) {
                                    echo 'Thanh Toán Qua VNPay';
                                } elseif ($paymentMethod == 2) {
                                    echo 'Thanh Toán qua MoMo';
                                } else {
                                    echo 'Thanh Toán Khi Nhận Hàng';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>

                <a href="index.php?quanly=processing" class="btn--outline btn-cart-continue mb-3">
                    <span class="icon-ic_left-arrow"><i class="fa-solid fa-arrow-left-long"></i></span>
                    Trở Về Xem Đơn Hàng
                </a>

            </div>
            <div class="col-md-5">
                <h2 class="font-weight-bold text-lg">Danh Sách Sản Phẩm</h2>
                <div class="border-bottom" style="overflow-y: auto; max-height: 200px;">
                    <?php
                    $subtotal = 0;


                    while ($row_order_detail = mysqli_fetch_array($sql_order_detail)) {
                        $total = $row_order_detail['product_rice'] * $row_order_detail['cart_quantity'];
                        $subtotal += $total;
                    ?>
                        <div class="d-flex justify-content-between pt-2">
                            <div class="d-flex">
                                <div class="position-relative" style="overflow-y: visible;">
                                    <img style="width: 60px;" class="rounded" src="./upload/img/Product/<?php echo $row_order_detail['img1_product'] ?>" alt="">
                                    <span style="width: 20px; height: 20px; margin: -6px -13px; position: absolute;" class="d-inline-flex align-items-center justify-content-center bg-primary p-2 rounded-circle">
                                        <?php echo $row_order_detail['cart_quantity'] ?>
                                    </span>
                                </div>
                                <div class="pt-5 ml-2">
                                    <span class="font-weight-bold">
                                        <?php echo $row_order_detail['product_name'] ?>
                                    </span>
                                    <p>
                                        <?php echo $row_order_detail['cart_size'] ?>
                                    </p>
                                </div>
                            </div>
                            <div class="pt-5">
                                <span class="font-weight-bold">
                                    <?php echo number_format($row_order_detail['product_rice'], 0, '.', '.') . 'đ' ?>
                                </span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="border-bottom pt-2">
                    <div class="d-flex justify-content-between">
                        <p>Tạm Tính : </p>
                        <span class="font-weight-bold">
                            <?php echo number_format($subtotal, 0, '.', '.') . 'đ' ?>
                        </span>

                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Giảm Giá :</p>
                        <span>0đ</span>

                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Phí Vận Chuyển :</p>
                        <span>Miễn Phí</span>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between">
                        <p>Tổng Tiền : </p>
                        <span class="font-weight-bold">
                            <?php echo number_format($subtotal, 0, '.', '.') . 'đ' ?>
                        </span>
                    </div>
                </div>
                <?php if ($row_left_order['order_cancel'] == 0) { ?>
                    <div class="d-flex justify-content-end">
                        <a href="?quanly=order_client_view&id=<?php echo $row_left_order['ma_order'] ?>&huydon=1" style="<?php echo ($row_left_order['order_status'] == 0 && $row_left_order['payment_method'] == '4') ? '' : 'display: none;'; ?>" name="huydon" class="add-to-cart-detail">
                            Hủy Đơn
                        </a>
                    </div>
                <?php } elseif ($row_left_order['order_cancel'] == 2) { ?>
                    <div class="d-flex justify-content-end">
                        <p class="order-cancel">
                            Đã Hủy
                        </p>
                    </div>
                <?php } else { ?>
                    <div class="d-flex justify-content-end">
                        <p class="order-cancel">
                            Đang Yêu Cầu Hủy
                        </p>
                    </div>
                <?php } ?>
                <?php if ($row_left_order['order_cancel'] != 1 && $row_left_order['order_cancel'] != 2) { ?>
                    <div class="d-flex justify-content-end mt-3">
                        <span>Tình Trạng Đơn Hàng:
                            <span class="<?php echo $row_left_order['order_status'] == 0 ? 'text-primary' : 'text-danger' ?>">
                                <?php echo $row_left_order['order_status'] == 0 ? 'Chờ Xác Nhận' : 'Đang Vận Chuyển' ?>
                            </span>
                        </span>
                    </div>
                <?php } ?>


        </form>
    <?php } ?>
</main>
<script>
    document.querySelector('.add-to-cart-detail').addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết

        Swal.fire({
            title: 'Xác nhận hủy đơn',
            text: 'Bạn có chắc chắn muốn hủy đơn?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hủy đơn',
            cancelButtonText: 'Không',
        }).then((result) => {
            if (result.isConfirmed) {
                const url = this.getAttribute('href');
                window.location.href = url; // Chuyển hướng đến URL chỉ định
            } else {
                Swal.close();
            }
        });
    });
</script>
<script>
    function validateForm() {
        const isChecked = Array.from(document.querySelectorAll('input[name="selected_orders[]"]:checked')).length > 0;

        if (!isChecked) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Vui lòng chọn ít nhất một đơn hàng để xóa.',
            });
            return false;
        }
        return true;
    }
</script>