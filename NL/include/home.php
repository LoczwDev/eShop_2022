<?php
// exit();
?>
<main>
    <section class="banner">
        <!-- nguồn tham khỏa: https://getbootstrap.com/docs/4.0/components/carousel/ -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            </ol>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="./assets/img/Banner/img-banner1.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="./assets/img/Banner/img-banner2.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="./assets/img/Banner/img-banner3.jpg" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="./assets/img/Banner/img-banner4.jpg" alt="Fourth slide">
                </div>
            </div>
            <a class="carousel-control-prev custom-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <i class="fa-solid fa-arrow-left-long"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next custom-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <i class="fa-solid fa-arrow-right-long"></i>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </section>
    <section class="new-product">
        <div class="main-title">
            <h1>NEW ARRIVAL</h1>
        </div>
        <div class="tabs">
            <ul class="list-tabs">
                <li class="active-tab"><a href="#product-girl">IVY moda</a></li>
                <li><a href="#product-boy">IVY men</a></li>
                <li><a href="#product-kid">IVY kids</a></li>
            </ul>
            <div class="tab-content">
                <div class="card-container" id="product-girl">
                    <div class="list-product__new">
                        <?php
                        $sql_product = mysqli_query($conn, 'SELECT * FROM product_list WHERE product_new ="1" AND category_id="1" ORDER BY product_id DESC LIMIT 10');
                        $count = 0;
                        while ($row_product = mysqli_fetch_array($sql_product)) {
                            $count++;
                        ?>
                            <div class="product-card">
                                <a href="?quanly=product_Details&id=<?php echo $row_product['product_id'] ?>">
                                    <?php if ($count > 1) {
                                        echo
                                        '<div class="info-ticket ticket-news">NEW</div>';
                                    }
                                    ?>
                                    <img src="./upload/img/Product/<?php echo $row_product['img1_product'] ?>" class="card-img-top" alt="...">
                                    <img src="./upload/img/Product/<?php echo $row_product['img2_product'] ?>" class="card-img-top hover-img-card" alt="...">
                                </a>
                                <div class="card-body">
                                    <div class="list-color">
                                        <span class="text-dark font-weight-bolder">Màu Sắc: </span>
                                        <div class="color-item mr-5">
                                            <span class="ds__item__label check-color mr-4" data-toggle="tooltip" data-original-title="<?php echo $row_product['product_color'] ?>">
                                                <img class="w-50 h-50" src="./upload/img/Color/<?php echo $row_product['product_color'] ?>.png" title="...">
                                                <span class="tooltip"><?php echo $row_product['product_color'] ?></span>
                                            </span>
                                        </div>
                                        <div class="favourite">
                                            <i class="fa-regular fa-heart"></i>
                                        </div>
                                    </div>
                                    <a href="?quanly=product_Details&id=<?php echo $row_product['product_id'] ?>">
                                        <p class="card-text"><small>
                                                <?php echo $row_product['product_name'] ?>
                                            </small>
                                        </p>
                                    </a>

                                    <div class="rice-product">
                                        <h5 class="card-title">
                                            <?php echo number_format($row_product['product_rice'], 0, '.', '.') . 'đ'; ?>
                                        </h5>
                                        <form class="cartForm" action="?quanly=cart" method="post">
                                            <div class="add-to-cart">
                                                <a href="#" class="cart-icon">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                </a>
                                            </div>
                                            <div class="list-size open-size">
                                                <?php $product_id = $row_product['product_id'];
                                                $sql_size = mysqli_query($conn, "SELECT * FROM size_list WHERE product_id = '$product_id'"); ?>
                                                <ul>
                                                    <div class="subSize-home">
                                                        <?php while ($row_size = mysqli_fetch_array($sql_size)) { ?>
                                                            <label>
                                                                <input class="select-size font-weight-bolder" <?php echo $row_size['size_quantity'] == 0 ? 'disabled' : ''; ?> type="submit" data-quantity="<?php echo $row_size['size_quantity']; ?>" value="<?php echo $row_size['size_name']; ?>" name="addCart"> </label>
                                                        <?php } ?>
                                                    </div>

                                                </ul>
                                            </div>
                                            <input type="hidden" name="product_id" value="<?php echo $row_product['product_id'] ?>">
                                            <input type="hidden" name="cart_name" value="<?php echo $row_product['product_name'] ?>">
                                            <input type="hidden" name="cart_rice" value="<?php echo $row_product['product_rice'] ?>">
                                            <input type="hidden" name="cart_img" value="<?php echo $row_product['img1_product'] ?>">
                                            <input type="hidden" name="cart_color" value="<?php echo $row_product['product_color']; ?>">
                                            <input class="selectedSizeInput" type="hidden" name="cart_size">
                                            <input type="hidden" class="maxQuantity" name="maxQuantity">
                                            <input class="cartQuantityInput" type="hidden" name="cart_quantity" value="1">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php $sql_seeAll = mysqli_query($conn, "SELECT * FROM category_list WHERE category_id='1' ORDER BY category_id ASC");
                    $row_seeAll = mysqli_fetch_assoc($sql_seeAll);
                    ?>
                    <div class="link-product">
                        <a href="?quanly=category&id=<?php echo $row_seeAll['category_id'] ?>">Xem Tất Cả</a>
                    </div>
                </div>
                <div class="card-container" id="product-boy">
                    <div class="list-product__new">

                        <?php
                        $sql_product = mysqli_query($conn, 'SELECT * FROM product_list WHERE product_new ="1" AND category_id="2" ORDER BY product_id DESC LIMIT 10');
                        $count = 0;
                        while ($row_product = mysqli_fetch_array($sql_product)) {
                            $count++;
                        ?>
                            <div class="product-card">
                                <a href="?quanly=product_Details&id=<?php echo $row_product['product_id'] ?>">
                                    <?php if ($count > 1) {
                                        echo
                                        '<div class="info-ticket ticket-news">NEW</div>';
                                    }
                                    ?>
                                    <img src="./upload/img/Product/<?php echo $row_product['img1_product'] ?>" class="card-img-top" alt="...">
                                    <img src="./upload/img/Product/<?php echo $row_product['img2_product'] ?>" class="card-img-top hover-img-card" alt="...">
                                </a>
                                <div class="card-body">
                                    <div class="list-color">
                                        <span class="text-dark font-weight-bolder">Màu Sắc: </span>
                                        <div class="color-item mr-5">
                                            <span class="ds__item__label check-color mr-4" data-toggle="tooltip" data-original-title="<?php echo $row_product['product_color'] ?>">
                                                <img class="w-50 h-50" src="./upload/img/Color/<?php echo $row_product['product_color'] ?>.png" title="...">
                                                <span class="tooltip"><?php echo $row_product['product_color'] ?></span>
                                            </span>
                                        </div>
                                        <div class="favourite">
                                            <i class="fa-regular fa-heart"></i>
                                        </div>
                                    </div>
                                    <a href="?quanly=product_Details&id=<?php echo $row_product['product_id'] ?>">
                                        <p class="card-text"><small>
                                                <?php echo $row_product['product_name'] ?>
                                            </small>
                                        </p>
                                    </a>
                                    <div class="rice-product">
                                        <h5 class="card-title">
                                            <?php echo number_format($row_product['product_rice'], 0, '.', '.') . 'đ'; ?>
                                        </h5>
                                        <form class="cartForm" action="?quanly=cart" method="post">
                                            <div class="add-to-cart">
                                                <a href="#" class="cart-icon">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                </a>
                                            </div>
                                            <div class="list-size open-size">
                                                <?php $product_id = $row_product['product_id'];
                                                $sql_size = mysqli_query($conn, "SELECT * FROM size_list WHERE product_id = '$product_id'"); ?>
                                                <ul>
                                                    <div class="subSize-home">
                                                        <?php while ($row_size = mysqli_fetch_array($sql_size)) { ?>
                                                            <label>
                                                                <input class="select-size" <?php echo $row_size['size_quantity'] == 0 ? 'disabled' : ''; ?> type="submit" data-quantity="<?php echo $row_size['size_quantity']; ?>" value="<?php echo $row_size['size_name']; ?>" name="addCart">
                                                            </label>
                                                        <?php } ?>
                                                    </div>

                                                </ul>
                                            </div>
                                            <input type="hidden" name="product_id" value="<?php echo $row_product['product_id'] ?>">
                                            <input type="hidden" name="cart_name" value="<?php echo $row_product['product_name'] ?>">
                                            <input type="hidden" name="cart_rice" value="<?php echo $row_product['product_rice'] ?>">
                                            <input type="hidden" name="cart_img" value="<?php echo $row_product['img1_product'] ?>">
                                            <input type="hidden" name="cart_color" value="<?php echo $row_product['product_color']; ?>">
                                            <input class="selectedSizeInput" type="hidden" name="cart_size">
                                            <input type="hidden" class="maxQuantity" name="maxQuantity">
                                            <input class="cartQuantityInput" type="hidden" name="cart_quantity" value="1">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php $sql_seeAll = mysqli_query($conn, "SELECT * FROM category_list WHERE category_id='2' ORDER BY category_id ASC");
                    $row_seeAll = mysqli_fetch_assoc($sql_seeAll);
                    ?>
                    <div class="link-product">
                        <a href="?quanly=category&id=<?php echo $row_seeAll['category_id'] ?>">Xem Tất Cả</a>
                    </div>
                </div>
                <div class="card-container" id="product-kid">
                    <div class="list-product__new">

                        <?php
                        $sql_product = mysqli_query($conn, 'SELECT * FROM product_list WHERE product_new ="1" AND category_id="3" ORDER BY product_id DESC LIMIT 10');
                        $count = 0;
                        while ($row_product = mysqli_fetch_array($sql_product)) {
                            $count++;
                        ?>
                            <div class="product-card">
                                <a href="?quanly=product_Details&id=<?php echo $row_product['product_id'] ?>">
                                    <?php if ($count > 1) {
                                        echo
                                        '<div class="info-ticket ticket-news">NEW</div>';
                                    }
                                    ?>
                                    <img src="./upload/img/Product/<?php echo $row_product['img1_product'] ?>" class="card-img-top" alt="...">
                                    <img src="./upload/img/Product/<?php echo $row_product['img2_product'] ?>" class="card-img-top hover-img-card" alt="...">
                                </a>
                                <div class="card-body">
                                    <div class="list-color">
                                        <span class="text-dark font-weight-bolder">Màu Sắc: </span>
                                        <div class="color-item mr-5">
                                            <span class="ds__item__label check-color mr-4" data-toggle="tooltip" data-original-title="<?php echo $row_product['product_color'] ?>">
                                                <img class="w-50 h-50" src="./upload/img/Color/<?php echo $row_product['product_color'] ?>.png" title="...">
                                                <span class="tooltip"><?php echo $row_product['product_color'] ?></span>
                                            </span>
                                        </div>
                                        <div class="favourite">
                                            <i class="fa-regular fa-heart"></i>
                                        </div>
                                    </div>
                                    <a href="?quanly=product_Details&id=<?php echo $row_product['product_id'] ?>">
                                        <p class="card-text"><small>
                                                <?php echo $row_product['product_name'] ?>
                                            </small>
                                        </p>
                                    </a>
                                    <div class="rice-product">
                                        <h5 class="card-title">
                                            <?php echo number_format($row_product['product_rice'], 0, '.', '.') . 'đ'; ?>
                                        </h5>
                                        <form class="cartForm" action="?quanly=cart" method="post">
                                            <div class="add-to-cart">
                                                <a href="#" class="cart-icon">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                </a>
                                            </div>
                                            <div class="list-size open-size">
                                                <?php $product_id = $row_product['product_id'];
                                                $sql_size = mysqli_query($conn, "SELECT * FROM size_list WHERE product_id = '$product_id'"); ?>
                                                <ul>
                                                    <div class="subSize-home">
                                                        <?php while ($row_size = mysqli_fetch_array($sql_size)) { ?>
                                                            <label>
                                                                <input class="select-size" <?php echo $row_size['size_quantity'] == 0 ? 'disabled' : ''; ?> type="submit" data-quantity="<?php echo $row_size['size_quantity']; ?>" value="<?php echo $row_size['size_name']; ?>" name="addCart"> </label>
                                                        <?php } ?>
                                                    </div>

                                                </ul>
                                            </div>
                                            <input type="hidden" name="product_id" value="<?php echo $row_product['product_id'] ?>">
                                            <input type="hidden" name="cart_name" value="<?php echo $row_product['product_name'] ?>">
                                            <input type="hidden" name="cart_rice" value="<?php echo $row_product['product_rice'] ?>">
                                            <input type="hidden" name="cart_img" value="<?php echo $row_product['img1_product'] ?>">
                                            <input type="hidden" name="cart_color" value="<?php echo $row_product['product_color']; ?>">
                                            <input class="selectedSizeInput" type="hidden" name="cart_size">
                                            <input type="hidden" class="maxQuantity" name="maxQuantity">
                                            <input class="cartQuantityInput" type="hidden" name="cart_quantity" value="1">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php $sql_seeAll = mysqli_query($conn, "SELECT * FROM category_list WHERE category_id='3' ORDER BY category_id ASC");
                    $row_seeAll = mysqli_fetch_assoc($sql_seeAll);
                    ?>
                    <div class="link-product">
                        <a href="?quanly=category&id=<?php echo $row_seeAll['category_id'] ?>">Xem Tất Cả</a>
                    </div>
                </div>
                <div class="controls">
                    <button class="pre-btn"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="nxt-btn"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>

        </div>
    </section>
    <section class="list-ads-brand">
        <div class="container-brand">
            <div class="brand-main">
                <a href="#">
                    <img src="./assets/img/Brand/main-Brand.jpg" alt="">
                </a>
            </div>
            <div class="brand-extra owl-carousel owl-theme">
                <div class="item">
                    <a class="brand-extra__item" href="#">
                        <img src="./assets/img/Brand/exrtra-Brand1.jpg" alt="">
                    </a>
                </div>
                <div class="item">
                    <a class="brand-extra__item" href="#">
                        <img src="./assets/img/Brand/exrtra-Brand2.jpg" alt="">
                    </a>
                </div>
                <div class="item">
                    <a class="brand-extra__item" href="#">
                        <img src="./assets/img/Brand/exrtra-Brand1.jpg" alt="">
                    </a>
                </div>
                <div class="item">
                    <a class="brand-extra__item" href="#">
                        <img src="./assets/img/Brand/exrtra-Brand2.jpg" alt="">
                    </a>
                </div>

            </div>
        </div>
    </section>
    <section class="list-gallery">
        <h3 class="title-gallery">GALLERY</h3>
        <div class="carousel-gallery owl-carousel owl-theme">
            <div class="item">
                <a class="gallery-item" href="#">
                    <img src="./assets/img/Gallery/gallery1.jpg" alt="">
                </a>
            </div>
            <div class="item">
                <a class="gallery-item" href="#">
                    <img src="./assets/img/Gallery/gallery2.jpg" alt="">
                </a>
            </div>
            <div class="item">
                <a class="gallery-item" href="#">
                    <img src="./assets/img/Gallery/gallery3.jpg" alt="">
                </a>
            </div>
            <div class="item">
                <a class="gallery-item" href="#">
                    <img src="./assets/img/Gallery/gallery4.jpg" alt="">
                </a>
            </div>
            <div class="item">
                <a class="gallery-item" href="#">
                    <img src="./assets/img/Gallery/gallery5.jpg" alt="">
                </a>
            </div>
        </div>


    </section>
</main>
