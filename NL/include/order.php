<main>


    <?php
    // $client_id = $_SESSION['user_id_client'];
    $subtotal = $_SESSION['subtotal'];
    // print_r($subtotal);

    if (isset($_POST['delivery'])) {

        $client_name = $_POST['client_name'];
        $client_phone = $_POST['client_phone'];
        $client_address = $_POST['client_address'];
        $order_note = $_POST['order_note'];


        if (empty($client_name) || empty($client_phone) || empty($client_address)) {
            $error_message = 'Vui lòng điền đầy đủ thông tin.';
        } elseif (!isset($_POST['payment_method'])) {
            $error_message = 'Vui lòng chọn hình thức thanh toán.';
        } else {
            $payment_method = $_POST['payment_method'];

            $ma_order = rand(0, 9999);
            $_SESSION['ma_order'] = $ma_order;

            // Lấy danh sách sản phẩm trong giỏ hàng
            $sql_get_cart = mysqli_query($conn, "SELECT * FROM cart_list WHERE client_id = '$client_id'");
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

                echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Đặt Hàng thành công!",
                            showConfirmButton: false,
                            timer: 4000
                        }).then(() => {
                            window.location.href = "./thanks.php";
                        });
                    </script>';
            }
            // }
        }
    }
    ?>
    <?php if (!empty($error_message)) : ?>
        <script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Chưa nhập đủ thông tin',
                    text: '<?php echo $error_message; ?>'
                });
            });
        </script>
    <?php endif; ?>
    <section class="section-cart">
        <div class="container-custom">
            <div class="container-cart__step1">
                <form name="form_larger" method="post" action="">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <div class="checkout-process-bar block-border">
                                <ul>
                                    <li class="active"><span>Giỏ hàng </span></li>
                                    <li class="active"><span>Đặt hàng</span></li>
                                    <li class=""><span>Thanh toán</span></li>
                                    <li><span>Hoàn thành đơn</span></li>
                                </ul>
                                <p class="checkout-process-bar__title">Giỏ hàng</p>
                            </div>
                            <div class="checkout-address-delivery">
                                <div class="row">
                                    <div class="col-12 col-md-7 col-lg-7 pb-3t" id="infoClient">
                                        <h3 class="checkout-title">Địa chỉ giao hàng
                                        </h3>
                                        <div class="ds__item info-location">
                                            <span class="ds__item__label">Địa chỉ</span>

                                            <div class="ds__item__contact-info">
                                                <div class="row">
                                                    <?php $info_client = mysqli_query($conn, "SELECT * FROM client WHERE client_id = '$client_id'");
                                                    $row_info = mysqli_fetch_array($info_client);
                                                    ?>
                                                    <div class="col-6 form-group">
                                                        <input class="form-control" type="text" value="<?php echo $row_info['client_name'] ?>" name="client_name" placeholder="Họ tên">
                                                    </div>
                                                    <div class="col-6 form-group">
                                                        <input class="form-control " type="text" name="client_phone" value="<?php echo $row_info['client_phone'] ?>" placeholder="Số điện thoại">
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <input class="form-control" type="text" placeholder="Địa chỉ" name="client_address" value="<?php echo $row_info['client_address'] ?>">
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <textarea class="form-control" style="resize: none;" name="order_note" cols="62" rows="5" placeholder="Ghi Chú"></textarea>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5 col-lg-5 pb-3 fade-in">
                                        <h3 class="checkout-title">Phương thức giao hàng</h3>
                                        <div class="block-border">
                                            <!-- hien tai chi lam phuong thuc giao nhanh -->
                                            <label class="ds__item">
                                                <input id="shipping_method_1" class="ds__item__input" type="radio" name="shipping_method" value="1" checked="">
                                                <span class="ds__item__label">Chuyển phát nhanh
                                                    <span class="delivery-time">
                                                        Thời gian giao hàng dự kiến: <span class="font-weight-bolder h6" id="deliveryDate"></span>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-4 cart-page__col-summary">
                            <div class="cart-summary" id="cart-page-summary">
                                <div class="cart-summary__overview">
                                    <h3>Tổng tiền giỏ hàng</h3>
                                    <div class="cart-summary__overview__item">
                                        <p>Tổng tiền hàng</p>
                                        <p class="total-product">
                                            <?php echo number_format($subtotal, 0, '.', '.') . 'đ' ?>
                                        </p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Tạm tính</p>
                                        <p class="total-not-discount">
                                            <?php echo number_format($subtotal, 0, '.', '.') . 'đ' ?>
                                        </p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Phí vận chuyển</p>
                                        <p>
                                            <b class="order-price-total">
                                                0đ
                                            </b>
                                        </p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Tiền thanh toán</p>
                                        <p>
                                            <b class="order-price-total">
                                                <?php echo number_format($subtotal, 0, '.', '.') . 'đ' ?>
                                            </b>
                                        </p>
                                    </div>
                                </div>
                                <div class="cart-summary__voucher-form">
                                    <div class="cart-summary__voucher-form__title">
                                        <h4 class="id-vourcher">Mã phiếu giảm giá</h4>
                                        <div class="form-group d-flex">
                                            <input class="form-control" type="text" placeholder="Mã giảm giá" name="coupon_code_text" id="coupon_code_text" value="">
                                            <button type="button" class="btn--outline btn-cart-continue" style="margin-top: 0;" id="but_coupon_code">Áp dụng</button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="cart-summary__button">
                                <input id="completeButton" class="btn--large" type="submit" name="delivery" value="Hoàn Thành">
                                <!-- <a  href="#" class="btn--large" id="purchase-step-1">Hoàn Thành</a> -->
                            </div>
                        </div>
                    </div>

                    <div class="checkout-payment">
                        <h3 class="checkout-title">Phương thức thanh toán</h3>
                        <div class="block-border">
                            <p>Mọi giao dịch đều được bảo mật và mã hóa. Thông tin thẻ tín dụng
                                sẽ không bao giờ được lưu lại.</p>
                            <div class="checkout-payment__options">
                                <form class="" name="form_vnpay" method="POST" action="pages/vnpay.php">
                                    <label class="ds__item">
                                        <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_1" value="1">
                                        <span class="ds__item__label">
                                            Thanh toán qua VNPay
                                            <span>Hỗ trợ thanh toán online hơn 38 ngân hàng phổ biến Việt Nam.</span>
                                        </span>
                                    </label>
                                    <!-- <input type="hidden" name="vnpay"> -->
                                </form>
                                <form id="atm-MOMO" class="" name="form_momoATM" method="POST" action="Payment/MoMo/index.php">
                                    <label class="ds__item">
                                        <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_2" value="2">
                                        <span class="ds__item__label">
                                            Thanh toán bằng MOMO
                                        </span>
                                    </label>
                                    <!-- <input type="hidden" name="momoATM"> -->
                                </form>

                                <form class="" name="form_momoQR" method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="../Payment/MoMo/init_payment.php">
                                    <label class="ds__item">
                                        <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_3" value="3">
                                        <span class="ds__item__label">
                                            Thanh toán bằng MomoQR
                                        </span>
                                    </label>
                                    <!-- <input type="hidden" name="momoQR"> -->
                                </form>
                                <label class="ds__item">
                                    <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_4" value="4">
                                    <span class="ds__item__label">
                                        Thanh toán khi giao hàng
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<script>
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const infoClient = document.getElementById('infoClient');

    function hideInfoClient() {
        infoClient.classList.add('fade-out');
        infoClient.classList.remove('fade-in');

        setTimeout(function() {
            infoClient.classList.remove('fade-out');
            infoClient.style.display = 'none';

        }, 500);
    }
    paymentMethods.forEach(function(radio) {
        radio.addEventListener('change', function() {
            paymentMethods.forEach(function(otherRadio) {
                if (otherRadio !== radio) {
                    otherRadio.checked = false;
                    console.log(radio.value);
                }
                if (radio.value === '4') {
                    infoClient.classList.add('fade-in');
                    infoClient.classList.remove('fade-out');
                    infoClient.style.display = 'block'

                } else {
                    hideInfoClient()
                }
            });
        });
    });
    infoClient.style.display = 'none';
</script>
<script>
    const deliveryDateDisplay = document.getElementById('deliveryDate');

    function DayOrder() {
        const currentDate = new Date();
        const deliveryDate = new Date(currentDate.getTime() + (3 * 24 * 60 * 60 * 1000));
        const options = {
            weekday: 'long',
            day: 'numeric',
            month: 'numeric',
            year: 'numeric'
        };
        const formatDate = deliveryDate.toLocaleDateString('vi-VN', options);
        deliveryDateDisplay.textContent = formatDate;
    }

    DayOrder();
</script>
<script>
    document.getElementById("completeButton").addEventListener("click", function(event) {
        const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const atmMOMO = document.getElementById('atm-MOMO');
        const completeButton = document.getElementById('completeButton').value;
        let shouldSubmitForm = true;

        switch (selectedPaymentMethod) {
            case "1":
                // document.forms["form_larger"].submit();

                window.location.href = "/NL/Payment/vnpay_php/index.php";
                break;
            case "2":
                // window.location.href = "pages/atm_momo.php";
                atmMOMO.submit(); // Chuyển đến trang atm_momo.php
                break;
            case "3":
                window.location.href = "./Payment/MoMo/init_payment.php";
                break;
            case "4":
                shouldSubmitForm = false;
                break;
            default:
                break;
        }

        if (shouldSubmitForm) {
            event.preventDefault();

        }
    });
</script>