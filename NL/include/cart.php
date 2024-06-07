<main>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['maxQuantity'])) {
            // Xử lý thêm sản phẩm vào giỏ hàng
            $product_id = $_POST['product_id'];
            $cart_color = $_POST['cart_color'];
            $cart_size = $_POST['cart_size'];
            $cart_name = $_POST['cart_name'];
            $cart_rice = $_POST['cart_rice'];
            $cart_img = $_POST['cart_img'];
            $cart_quantity = $_POST['cart_quantity'];
            $maxQuantity = $_POST['maxQuantity'];

            $sql_select_cart = mysqli_query($conn, "SELECT * FROM cart_list WHERE product_id='$product_id' AND cart_size='$cart_size' AND client_id='$client_id'");
            $count = mysqli_num_rows($sql_select_cart);

            if ($count > 0) {
                // Sản phẩm đã có trong giỏ hàng, cập nhật số lượng
                $row_check_product = mysqli_fetch_array($sql_select_cart);
                $quantity = $row_check_product['cart_quantity'];
                $new_quantity = $quantity + $cart_quantity;
                $sql_cart = "UPDATE cart_list SET cart_quantity='$new_quantity' WHERE product_id='$product_id' AND cart_size='$cart_size' AND client_id='$client_id'";
            } else {
                // Sản phẩm chưa có trong giỏ hàng, thêm mới
                $sql_cart = "INSERT INTO cart_list (client_id, product_id, cart_name, cart_rice, cart_img, cart_quantity, cart_size, cart_color, max_quantity) VALUES ('$client_id', '$product_id', '$cart_name', '$cart_rice', '$cart_img', '$cart_quantity', '$cart_size', '$cart_color', '$maxQuantity')";
            }

            $insert_row = mysqli_query($conn, $sql_cart);
        } elseif (isset($_POST['updateCart'])) {
            // Xử lý cập nhật giỏ hàng
            for ($i = 0; $i < count($_POST['cart_id']); $i++) {
                $cart_id = $_POST['cart_id'][$i];
                $cart_quantity = $_POST['quantity'][$i];
                $cart_size = $_POST['cart_size'][$i];

                $sql_select_cart = mysqli_query($conn, "SELECT * FROM cart_list WHERE cart_id='$cart_id' AND client_id='$client_id'");
                $row_select_cart = mysqli_fetch_assoc($sql_select_cart);

                if ($row_select_cart) {
                    $current_quantity = $row_select_cart['cart_quantity'];

                    if ($current_quantity != $cart_quantity) {
                        $sql_update = mysqli_query($conn, "UPDATE cart_list SET cart_quantity='$cart_quantity' WHERE cart_id='$cart_id' AND client_id='$client_id'");
                    }
                }
            }
        }
    } elseif (isset($_GET['deleter'])) {
        // Xử lý xóa sản phẩm khỏi giỏ hàng
        $id_del = $_GET['deleter'];
        $sql_deleter = mysqli_query($conn, "DELETE FROM cart_list WHERE cart_id='$id_del' AND client_id='$client_id'");
    }

    ?>
    <section class="section-cart">
        <div class="container-custom">
            <!-- <form name="frm-cart" id="frm-cart" method="post" action=""> -->
            <div class="container-cart">
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="checkout-process-bar block-border">
                            <ul>
                                <li class="active"><span>Giỏ hàng </span></li>
                                <li class=""><span>Đặt hàng</span></li>
                                <li class=""><span>Thanh toán</span></li>
                                <li><span>Hoàn thành đơn</span></li>
                            </ul>
                            <p class="checkout-process-bar__title">Giỏ hàng</p>
                        </div>
                        <div id="box_product_total_cart">
                            <div class="cart__list">
                                <?php
                                $sql_get_cart = mysqli_query($conn, "SELECT * FROM cart_list WHERE client_id = '$client_id' ORDER BY cart_id ASC");

                                ?>
                                <h2 class="cart-title">Giỏ hàng của bạn <b><span class="cart-total">
                                            <?php echo mysqli_num_rows($sql_get_cart); ?>
                                        </span> Sản phẩm</b></h2>

                                <table class="cart__table">
                                    <thead>
                                        <tr>
                                            <th>Tên Sản phẩm</th>
                                            <th>Chiết khấu</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        $subRice_cp = 0;
                                        $i = 0;
                                        while ($row_get_cart = mysqli_fetch_array($sql_get_cart)) {
                                            $subTottal = $row_get_cart['cart_quantity'] * $row_get_cart['cart_rice'];
                                            $total += $subTottal;
                                            $rice_cp = $row_get_cart['cart_rice'] * 0.1153;
                                            $subRice_cp += $rice_cp;
                                            $i++;
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="cart__product-item">
                                                        <div class="cart__product-item__img">
                                                            <a href="#">
                                                                <img src="upload/img/Product/<?php echo $row_get_cart['cart_img'] ?>" alt="Đầm lụa đuôi cá">
                                                            </a>
                                                        </div>
                                                        <div class="cart__product-item__content">
                                                            <a href="#">
                                                                <h3 class="cart__product-item__title">
                                                                    <?php echo $row_get_cart['cart_name'] ?>
                                                                </h3>
                                                            </a>
                                                            <div class="cart__product-item__properties">
                                                                <p>Màu sắc: <span>
                                                                        <?php echo $row_get_cart['cart_color'] ?>
                                                                    </span></p>
                                                                <p>Size: <span style="text-transform: uppercase">
                                                                        <?php echo $row_get_cart['cart_size'] ?>
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="cart-sale-price">
                                                    <p>
                                                        <?php echo number_format($rice_cp, 0, '.', '.') . 'đ'; ?>
                                                    </p>
                                                    <p class="cart-sale_item">
                                                        (
                                                        -11.53%
                                                        )
                                                    </p>
                                                </td>
                                                <td>

                                                    <form id="formUpdateCart" action="" method="post">
                                                        <div class="product-detail__quantity-input">
                                                            <input id="" name="quantity[]" type="number" value="<?php echo $row_get_cart['cart_quantity'] ?>" min="1" max="<?php echo $row_get_cart['max_quantity'] ?>">
                                                            <input name="sanpham_id[]" type="hidden" value="<?php echo $row_get_cart['product_id'] ?>">
                                                            <input type="hidden" name="cart_size[]" value="<?php echo $row_get_cart['cart_size'] ?>">
                                                            <input name="cart_id[]" type="hidden" value="<?php echo $row_get_cart['cart_id']; ?>">
                                                            <div class="product-detail__quantity--increase quantity_plus">
                                                                <button class="custom-quantity" type="submit" name="updateCart">+</button>
                                                            </div>
                                                            <div class="product-detail__quantity--decrease quantity_down">
                                                                <button class="custom-quantity" type="submit" name="updateCart">-</button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </td>
                                                <td>
                                                    <div class="cart__product-item__price">
                                                        <?php echo number_format($subTottal, 0, '.', '.') . 'đ'; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="?quanly=cart&deleter=<?php echo $row_get_cart['cart_id'] ?>" class="remove-item-cart"><span class="icon-ic_garbage"><i class="fa-solid fa-trash"></i></span></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <?php echo $i == 0 ? 'Bạn không có Sản Phẩm Nào Trong Giỏ Hàng!' : ''; ?>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                            <div class="cart__list--attach">
                            </div>
                            <a href="index.php" class="btn--outline btn-cart-continue mb-3">
                                <span class="icon-ic_left-arrow"><i class="fa-solid fa-arrow-left-long"></i></span>
                                Tiếp tục mua hàng
                            </a>
                        </div>


                    </div>
                    <div class="col-lg-4 col-md-4 cart-page__col-summary">
                        <div class="cart-summary" id="cart-page-summary">
                            <div class="cart-summary__overview">
                                <h3>Tổng tiền giỏ hàng</h3>
                                <div class="cart-summary__overview__item">
                                    <p>Tổng sản phẩm</p>
                                    <p class="total-product">
                                        <?php echo mysqli_num_rows($sql_get_cart); ?>
                                    </p>
                                </div>
                                <div class="cart-summary__overview__item">
                                    <p>Tổng tiền hàng</p>
                                    <p class="total-not-discount">
                                        <?php echo number_format($total, 0, '.', '.') . 'đ' ?>
                                    </p>
                                </div>
                                <div class="cart-summary__overview__item">
                                    <p>Thành tiền</p>
                                    <p>
                                        <b class="order-price-total">
                                            <?php echo number_format($total - $subRice_cp, 0, '.', '.') . 'đ';
                                            $_SESSION['subtotal'] = $total - $subRice_cp; ?>
                                        </b>
                                    </p>
                                </div>
                                <div class="cart-summary__overview__item">
                                    <p>Tạm tính</p>
                                    <p>
                                        <b class="order-price-total">
                                            <?php echo number_format($total - $subRice_cp, 0, '.', '.') . 'đ' ?>
                                        </b>
                                    </p>
                                </div>

                            </div>
                            <div class="cart-summary__note">
                                <div class="inner-note d-flex">
                                    <div class="left-inner-note">
                                        <span class="icon-ic_alert"><i class="fa-solid fa-circle-exclamation"></i></span>
                                    </div>
                                    <div class="content-inner-note">
                                        <p>Miễn <b>đổi trả</b> đối với sản phẩm đồng giá / sale trên 50%</p>
                                    </div>
                                    <div class="left-inner-note left-inner-note-shipping d-none">
                                        <span class="fa fa-check-circle text-success"></span>
                                    </div>
                                    <div class="content-inner-note content-inner-note-shipping d-none">
                                        <p class="text-success">Đơn hàng của bạn được Miễn phí ship</p>
                                        <div class="sub-note">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-summary__button">
                            <a href="?quanly=cart_Step1" class="btn--large" id="purchase-step-1">Đặt hàng</a>
                        </div>
                    </div>

                </div>

            </div>

            <!-- </form> -->

        </div>

    </section>
</main>
<script>
    document.getElementById('purchase-step-1').addEventListener('click', function(event) {
        const totalProducts = <?php echo mysqli_num_rows($sql_get_cart); ?>;

        if (totalProducts === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Giỏ hàng của bạn trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi đặt hàng.',
            });
            event.preventDefault(); 
        }
    });
</script>
<script>
    const increaseBtn_cart = document.querySelectorAll(".quantity_plus");
    const decreaseBtn_cart = document.querySelectorAll(".quantity_down");
    const quantityInputs = document.querySelectorAll('input[name="quantity[]"]');
    const formUpdateCart = document.getElementById('formUpdateCart');

    increaseBtn_cart.forEach((btn, index) => {
        btn.addEventListener("click", function() {
            let quantity = parseInt(quantityInputs[index].value);
            let maxQuantity = parseInt(quantityInputs[index].getAttribute('max'));
            if (quantity < maxQuantity) {
                quantity += 1;
                quantityInputs[index].value = quantity;
            } else {
                formUpdateCart.addEventListener("submit", function(event) {
                    event.preventDefault();

                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: 'Số lượng vượt quá giới hạn tối đa.'
                    });
                });
            }
        });
    });

    decreaseBtn_cart.forEach((btn, index) => {
        btn.addEventListener("click", function() {
            formUpdateCart.submit();
            let quantity = parseInt(quantityInputs[index].value);
            if (quantity > 1) {
                quantity -= 1;
                quantityInputs[index].value = quantity;
            }
        });
    });
</script>