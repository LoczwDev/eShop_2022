<main>
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = '';
    }
    $sql_product_details = mysqli_query($conn, "SELECT * FROM product_list WHERE product_id='$id'");
    $sql_count_size = mysqli_query($conn, "SELECT SUM(size_quantity) AS total_quantity FROM size_list WHERE product_id ='$id'");
    $row_product_size = mysqli_fetch_assoc($sql_count_size);
    $count_size = $row_product_size['total_quantity'];


    // breadcrumd
    $sql_cate_link = mysqli_query($conn, "SELECT * FROM category_list
    JOIN product_list ON category_list.category_id= product_list.category_id
    JOIN category_type ON category_type.typeCa_id = product_list.typeCa_id  WHERE product_id ='$id'");
    $row_link = mysqli_fetch_assoc($sql_cate_link);
    $title_cate = $row_link['category_name'];
    $category_type = $row_link['typeCa_id'];
    $color = $row_link['product_color'];


    ?>
    <section class="section-product__detail">
        <div class="container-custom">
            <div class="breadcrumb-products">
                <ul class="breadcrumb__list d-flex">
                    <li class="breadcrumb__item">
                        <a class="breadcrumb__link" href="../index.php">Trang Chủ</a>
                    </li>
                    <li class="breadcrumb__item">
                        <a class="breadcrumb__link" href="?quanly=category&id=<?php echo $row_link['category_id'] ?>">
                            <?php echo $title_cate ?>
                        </a>
                    </li>
                    <li class="breadcrumb__item">
                        <a class="breadcrumb__link not" href="#">
                            <?php echo (isset($_GET['quanly']) && $_GET['quanly'] == 'product_Details') ? $row_link['product_name'] : ''; ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="container-product__detail">
                <?php
                while ($row_pro_details = mysqli_fetch_array($sql_product_details)) {
                ?>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 big-product__img border-right">
                            <div class="zoom col-md-9">
                                <img id="imgOrigin" src="./upload/img/Product/<?php echo $row_pro_details['img1_product'] ?>" class="w-100 rounded " alt="...">
                                <img id="imgZoom" src="./upload/img/Product/<?php echo $row_pro_details['img1_product'] ?>" class="w-100 rounded " alt="...">
                            </div>
                            <div class="exrta-zoom col-md-3">
                                <img src="./upload/img/Product/<?php echo $row_pro_details['img1_product'] ?>" class="w-100 rounded " alt="..." onclick="changeImage(this.src)">
                                <img src="./upload/img/Product/<?php echo $row_pro_details['img2_product'] ?>" class="w-100 rounded " alt="..." onclick="changeImage(this.src)">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <form id="cartFrom" action="?quanly=cart" method="post">
                                <div class="product-detail__information">
                                    <h1 style="text-transform: uppercase;">
                                        <?php echo $row_pro_details['product_name'] ?>
                                    </h1>
                                    <div class="product-detail__sub-info mt-3">
                                        <p style="margin-bottom: 0;">
                                            Mã Sản Phẩm: <span>
                                                <?php echo $row_pro_details['product_id'] ?>
                                            </span>
                                        </p>
                                        <div class="product-detail__rating">
                                            <div class="product-detail__rating-wrapper" data-percentage="100">
                                                <div class="product-detail__rating__background"></div>
                                                <div class="product-detail__rating__bar" style="width: 100%;"></div>
                                            </div>
                                            <span>(0 đánh giá)</span>
                                        </div>
                                    </div>
                                    <div class="product-detail__price mt-3">
                                        <input type="hidden" name="hid_product_price_not_format" value="1890000">
                                        <b>
                                            <?php echo number_format($row_pro_details['product_rice'], 0, '.', '.') . 'đ'; ?>
                                        </b>
                                    </div>
                                    <div class="product-detail__color mt-3">
                                        <p style="font-weight: 600; font-size: 20px;">Màu sắc:
                                            <?php echo $row_pro_details['product_color'] ?>
                                        </p>
                                        <div class="list-color">
                                            <div class="color-item mr-5">
                                                <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="<?php echo $row_pro_details['product_color'] ?>">
                                                    <img class="w-50 h-50" src="./upload/img/Color/<?php echo $row_pro_details['product_color'] ?>.png" title="...">
                                                    <span class="tooltip"><?php echo $row_pro_details['product_color'] ?></span>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- <div class="product-detail__color__input">
                                            <div class="list-color">
                                                <ul>
                                                    <li class="checken"><a href="#"></a></li>
                                                    <li><a href="#"></a></li>
                                                </ul>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="product-detail__size__input mt-3">
                                        <div class="sidebarSub Sub-size">

                                            <?php
                                            $sql_product_size = mysqli_query($conn, "SELECT * FROM size_list WHERE product_id = '$id'");
                                            $sizeArray = array();
                                            if ($count_size !== 0) {
                                                while ($row_product_size = mysqli_fetch_array($sql_product_size)) {
                                                    $sizeName = $row_product_size['size_name'];
                                                    $sizeQuantity = $row_product_size['size_quantity'];

                                                    // Thêm tên kích thước và số lượng vào mảng
                                                    $sizeArray[] = array(
                                                        'name' => $sizeName,
                                                        'quantity' => $sizeQuantity
                                                    ); ?>
                                                    <label>
                                                        <input class="field-cat font-weight-bolder" type="radio" data-quantity="<?php echo $sizeQuantity ?>" value="<?php echo $sizeName ?>" name="size[]">
                                                        <span class="d-flex <?php echo $sizeQuantity == 0 ? 'disable' : '' ?>">
                                                            <?php echo $sizeName ?>
                                                        </span>
                                                    </label>
                                            <?php }
                                            } else {
                                                echo '<span class="font-weight-bolder text-danger">HẾT HÀNG</span>';
                                            } ?>
                                            <div id="selectedSizeDisplay"></div>
                                        </div>

                                    </div>
                                    <!-- Button trigger modal -->
                                    <div class="my-5 d-flex align-items-center h4">
                                        <span style="font-size: 16px;" class="material-symbols-outlined">
                                            design_services
                                        </span>
                                        <button style="font-size: 13px;" type="button" class="btn btn-normal" data-toggle="modal" data-target="#exampleModalLong">
                                            Kiểm tra size của bạn
                                        </button>
                                    </div>

                                    <!-- Modal -->
                                    <?php
                                    // print_r($sizeArray);
                                    include("include/model.php") ?>
                                    <!-- End-Modal -->

                                    <div class="product-detail__quantity">
                                        <p style="font-size: 16px; font-weight: 600; line-height: 1.2; vertical-align: baseline; margin-bottom: 0">
                                            Số lượng</p>
                                        <div class="product-detail__quantity-input">
                                            <input type="hidden" name="size_checked">
                                            <input type="hidden" name="product_sub_id">
                                            <input id="quantityInput" type="number" value="1" max="" name="quantity[]">
                                            <div class="product-quantity product-detail__quantity--increase ">+</div>
                                            <div class="product-quantity product-detail__quantity--decrease ">-</div>
                                        </div>
                                    </div>
                                    <div class="product-detail__actions">
                                        <!-- <button id="addToCartButton" name="addCart" class="addCart">
                                            Thêm vào giỏ
                                        </button> -->

                                        <input type="hidden" name="product_id" value="<?php echo $row_pro_details['product_id'] ?>">
                                        <input type="hidden" name="cart_name" value="<?php echo $row_pro_details['product_name'] ?>">
                                        <input type="hidden" name="cart_rice" value="<?php echo $row_pro_details['product_rice'] ?>">
                                        <input type="hidden" name="cart_img" value="<?php echo $row_pro_details['img1_product'] ?>">
                                        <input type="hidden" name="cart_color" value="<?php echo $row_pro_details['product_color']; ?>">
                                        <input id="selectedSizeInput" type="hidden" name="cart_size">
                                        <input id="cartQuantityInput" type="hidden" name="cart_quantity" value="1">
                                        <input type="hidden" id="maxQuantity" name="maxQuantity" value="">
                                        <button style="margin-top: 0;" type="submit" <?php echo $count_size > 0 ? '' : 'disabled' ?> 
                                        name="addCart" class="btn--outline btn-cart-continue addCart <?php echo $count_size > 0 ? '' : 'text-danger' ?>">
                                            <?php echo $count_size > 0 ? 'Mua Hàng' : 'Hiện Đang Hết Hàng' ?>
                                        </button>




                                        <button class="btn--outline">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>

                                    </div>
                                    <div class="tabs">
                                        <ul class="list-tabs detail-tab" style="border-bottom: 1px solid #c9baba;">
                                            <li class="active-tab"><a href="#mota">Mô tả</a></li>
                                            <li><a href="#baoquan">Bảo Quản</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="card-container" id="mota">
                                                <?php $mota = $row_pro_details['mota'] ? $row_pro_details['mota'] : 'Sản phẩm hiện chưa có mô tả';
                                                $paragraphs = explode("\n", $mota);
                                                foreach ($paragraphs as $paragraph) {
                                                    echo "<p>{$paragraph}</p>";
                                                } ?>
                                            </div>
                                            <div class="card-container" id="baoquan">
                                                <p>Chi tiết bảo quản sản phẩm :&nbsp;</p>

                                                <p><strong>* Các sản phẩm thuộc dòng cao cấp (Senora) và áo khoác (dạ, tweed,&nbsp;lông, phao) chỉ giặt khô,&nbsp;tuyệt đối không giặt ướt.</strong></p>

                                                <p>* Vải dệt kim: sau khi giặt sản phẩm phải được phơi ngang tránh bai giãn.</p>

                                                <p>* Vải voan, lụa, chiffon nên giặt bằng tay.</p>

                                                <p>* Vải thô, tuytsi, kaki không có phối hay trang trí đá cườm thì có thể giặt máy.</p>

                                                <p>* Vải thô, tuytsi, kaki có&nbsp;phối màu tương phản hay trang trí voan, lụa, đá cườm thì cần giặt tay.</p>

                                                <p>* Đồ Jeans nên hạn chế giặt bằng máy giặt vì sẽ làm phai màu jeans. Nếu giặt thì&nbsp;nên lộn trái sản phẩm khi giặt, đóng khuy, kéo khóa, không nên giặt chung cùng đồ sáng màu, tránh dính màu vào các sản phẩm khác.&nbsp;</p>

                                                <p>* Các sản phẩm cần được giặt ngay không ngâm tránh bị loang màu, phân biệt màu và loại vải để tránh trường hợp vải phai. Không nên giặt sản phẩm với xà phòng có chất tẩy mạnh, nên giặt cùng xà phòng pha loãng.</p>

                                                <p>* Các sản phẩm có thể&nbsp;giặt bằng máy thì chỉ nên để chế độ giặt nhẹ, vắt mức trung bình và nên phân các loại sản phẩm cùng màu và cùng loại vải khi giặt.</p>

                                                <p>* Nên phơi sản phẩm tại chỗ thoáng mát, tránh ánh nắng trực tiếp sẽ dễ bị phai bạc màu, nên làm khô quần áo bằng cách phơi ở những điểm gió sẽ giữ màu vải tốt hơn.</p>

                                                <p>* Những chất vải 100% cotton, không nên phơi sản phẩm bằng mắc áo mà nên vắt ngang sản phẩm lên dây phơi để tránh tình trạng rạn vải.</p>
                                            </div>
                                            <div class="show-more " onclick="toggleContent()">
                                                <div class="icon-show w-100">
                                                    <p id="icon-show"><i class="fa-solid fa-angle-down"></i></p>
                                                </div>

                                                <div class="inline"></div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </form>

                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="viewed-products mt-5">
                    <p class="viewed-products--title">Mua Cùng Với</p>
                    <div class="carousel-Viewed__product owl-carousel owl-theme">
                        <?php
                        $sql_product_similar = mysqli_query($conn, "SELECT * FROM product_list WHERE typeCa_id='$category_type' ORDER BY product_id ASC");
                        while ($row_product_similar = mysqli_fetch_array($sql_product_similar)) {
                        ?>
                            <div class="item">
                                <div class="product-card">
                                    <!-- <div class="info-ticket ticket-news">NEW</div> -->
                                    <img src="./upload/img/Product/<?php echo $row_product_similar['img1_product'] ?>" class="card-img-top" alt="...">
                                    <img src="./upload/img/Product/<?php echo $row_product_similar['img2_product'] ?>" class="card-img-top hover-img-card" alt="...">

                                    <div class="card-body">
                                        <div class="list-color">
                                            <span class="text-dark font-weight-bolder">Màu Sắc: </span>
                                            <div class="color-item mr-5">
                                                <span class="ds__item__label check-color mr-4" data-toggle="tooltip" data-original-title="<?php echo $row_product_similar['product_color'] ?>">
                                                    <img class="w-50 h-50" src="./upload/img/Color/<?php echo $row_product_similar['product_color'] ?>.png" title="...">
                                                    <span class="tooltip"><?php echo $row_product_similar['product_color'] ?></span>
                                                </span>
                                            </div>
                                            <div class="favourite">
                                                <i class="fa-regular fa-heart"></i>
                                            </div>
                                        </div>
                                        <a href="product_Details.php&id=<?php echo $row_product_similar['product_id'] ?>">
                                            <p class="card-text"><small>
                                                    <?php echo $row_product_similar['product_name'] ?>
                                                </small>
                                            </p>
                                        </a>
                                        </p>
                                        <div class="rice-product">
                                            <h5 class="card-title">
                                                <?php echo number_format($row_product_similar['product_rice'], 0, '.', '.') . 'đ'; ?>
                                            </h5>
                                            <form class="cartForm" action="?quanly=cart" method="post">
                                                <div class="add-to-cart">
                                                    <a href="#" class="cart-icon">
                                                        <i class="fa-solid fa-cart-shopping"></i>
                                                    </a>
                                                </div>
                                                <div class="list-size open-size">
                                                    <?php $product_id = $row_product_similar['product_id'];
                                                    $sql_size = mysqli_query($conn, "SELECT * FROM size_list WHERE product_id = '$product_id'"); ?>
                                                    <ul>
                                                        <div class="subSize-home">
                                                            <?php while ($row_size = mysqli_fetch_array($sql_size)) { ?>
                                                                <label>
                                                                    <input class="select-size font-weight-bolder" <?php echo $row_size['size_quantity'] == 0 ? 'disable' : ''  ?> type="submit" data-quantity="<?php echo $row_size['size_quantity'] ?>" value="<?php echo $row_size['size_name'] ?>" name="addCart">
                                                                </label>
                                                            <?php } ?>
                                                        </div>

                                                    </ul>
                                                </div>
                                                <input type="hidden" name="product_id" value="<?php echo $row_product_similar['product_id'] ?>">
                                                <input type="hidden" name="cart_name" value="<?php echo $row_product_similar['product_name'] ?>">
                                                <input type="hidden" name="cart_rice" value="<?php echo $row_product_similar['product_rice'] ?>">
                                                <input type="hidden" name="cart_img" value="<?php echo $row_product_similar['img1_product'] ?>">
                                                <input type="hidden" name="cart_color" value="<?php echo $row_product_similar['product_color']; ?>">
                                                <input class="selectedSizeInput" type="hidden" name="cart_size">
                                                <input type="hidden" class="maxQuantity" name="maxQuantity">
                                                <input class="cartQuantityInput" type="hidden" name="cart_quantity" value="1">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <div class="brand-main mt-5">
                        <a href="#">
                            <img src="./assets/img/Brand/main-Brand.jpg" alt="">
                        </a>
                    </div>
                </div>
    </section>

</main>
<script>
    const increaseBtn = document.querySelector(".product-detail__quantity--increase");
    const decreaseBtn = document.querySelector(".product-detail__quantity--decrease");
    const quantityInput = document.querySelector('input[name="quantity[]"]');
    const cartQuantityInput = document.getElementById("cartQuantityInput");

    increaseBtn.addEventListener("click", function() {
        let quantity = parseInt(quantityInput.value);
        quantity += 1;
        quantityInput.value = quantity;
        cartQuantityInput.value = quantity; // Cập nhật giá trị của cart_quantity
    });

    decreaseBtn.addEventListener("click", function() {
        let quantity = parseInt(quantityInput.value);
        if (quantity > 0) {
            quantity -= 1;
            quantityInput.value = quantity;
            cartQuantityInput.value = quantity; // Cập nhật giá trị của cart_quantity
        }
    });
</script>
<script>
    const addToCartButton = document.querySelector('.addCart');
    const sizeInputs = document.querySelectorAll('input[name="size[]"]');
    const loginSession = "<?php echo $login; ?>";

    addToCartButton.addEventListener('click', function(event) {
        const selectedSize = getSelectedSize();
        getMaxQuantity();
        const quantity = parseInt(quantityInput.value);
        if (loginSession === '') {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Lỗi',
                text: 'Bạn cần phải đăng nhập trước khi thêm vào giỏ hàng',
            });
        }

        if (!selectedSize || quantity > maxQuantity) {
            event.preventDefault();
            const message = selectedSize ?
                `Vui lòng chọn số lượng nhỏ hơn hoặc bằng ${maxQuantity}.` :
                'Vui lòng chọn size trước khi thêm vào giỏ hàng.';
            Swal.fire({
                icon: 'warning',
                title: 'Lỗi',
                text: message,
            });
        } else {
            addToCart(selectedSize, quantity);
        }
    });

    function getSelectedSize() {
        let selectedSize = '';
        sizeInputs.forEach(input => {
            if (input.checked) {
                selectedSize = input.value;
            }
        });
        document.getElementById('selectedSizeInput').value = selectedSize;
        return selectedSize;
    }

    function getMaxQuantity() {
        let maxQuantity = 0; // Khởi tạo maxQuantity
        sizeInputs.forEach(input => {
            if (input.checked) {
                maxQuantity = parseInt(input.dataset.quantity); // Lấy giá trị maxQuantity từ thuộc tính data-quantity
            }
        });
        document.getElementById('maxQuantity').value = maxQuantity;
        return maxQuantity;
    }
</script>

<script>
    // Lắng nghe sự kiện khi người dùng chọn kích thước
    const sizeInputste = document.querySelectorAll('.field-cat');
    sizeInputste.forEach(function(input) {
        input.addEventListener('change', function() {
            const quantityInput = document.getElementById('quantityInput');
            maxQuantity = parseInt(input.dataset.quantity);
        });
    });
</script>
<script>
    let zoom = document.querySelector('.zoom');
    let imgZoom = document.getElementById('imgZoom');

    zoom.addEventListener('mousemove', (e) => {
        let positionX = (e.pageX - zoom.getBoundingClientRect().left) / zoom.offsetWidth * 100;
        let positionY = (e.pageY - zoom.getBoundingClientRect().top) / zoom.offsetHeight * 100;

        imgZoom.style.opacity = 1;
        imgZoom.style.setProperty('--zoom-x', positionX + '%');
        imgZoom.style.setProperty('--zoom-y', positionY + '%');
    });

    zoom.addEventListener('mouseout', (e) => {
        imgZoom.style.opacity = 0;
    });
</script>
<script>
    function changeImage(src) {
        document.getElementById("imgZoom").src = src;
        document.getElementById("imgOrigin").src = src;
    }
</script>
<script>
    function toggleContent() {
        var contentMota = document.getElementById("mota");
        var contentBaoquan = document.getElementById("baoquan");
        var iconShow = document.getElementById("icon-show");
        contentMota.classList.toggle("active");
        contentBaoquan.classList.toggle("active");
        iconShow.classList.toggle("active");

    }
</script>