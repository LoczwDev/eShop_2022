<main>
    <?php


    if (isset($_POST["search_keyword"])) {
        $keyWord = isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';
        $sql = "SELECT * FROM product_list WHERE product_name LIKE '%$keyWord%'";
        $_SESSION['category_sort'] = $sql;
        // print_r($_SESSION['category_sort']);
        $title = $keyWord;
    }
    if (isset($_POST['sort'])) {
        $sort = $_POST['sort'];
    } else {
        $sort = 'default';
    }

    if (isset($_SESSION['category_sort'])) {
        $sql = $_SESSION['category_sort'];
        $mess_sort = '';

        if ($sort == 'name-az') {
            $sql .= " ORDER BY product_list.product_name ASC";
            $mess_sort = 'Xắp sếp từ A-Z';
        } elseif ($sort == 'name-za') {
            $sql .= " ORDER BY product_list.product_name DESC";
            $mess_sort = 'Xắp sếp từ Z-A';
        } elseif ($sort == 'price-high') {
            $sql .= " ORDER BY product_list.product_rice DESC";
            $mess_sort = 'Xắp sếp theo giá: Cao-Thấp';
        } elseif ($sort == 'price-low') {
            $sql .= " ORDER BY product_list.product_rice ASC";
            $mess_sort = 'Xắp sếp theo giá: Thấp-cao';
        }
    }


    $sql_search = mysqli_query($conn, $sql);
    if (mysqli_num_rows($sql_search) == 0) {
        $message = 'Không tìm thấy kết quả cho từ khóa tìm kiếm "' . $keyWord . '"';
    }
    ?>

    <!-- Hiển thị thông báo -->

    <section class="section-cartegory">
        <div class="list-product-cartegory d-flex">
            <div class="sidebar-cartegory col-md-3 col-lg-3">
                <form action="?quanly=filter" method="post">
                    <ul class="list-sidebar">
                        <li class="list-sidebar-item">
                            <p class="title-sidebar-item mt-3 mb-3">
                                Loại
                                <span class="icon-plus">
                                    <i class="fa-solid fa-angle-down"></i>
                                </span>
                            </p>
                            <div class="sidebarSub Sub-color">
                                <?php $sql_categoryType = mysqli_query($conn, "SELECT * FROM category_type") ?>
                                <div class="d-flex container-color">
                                    <?php while ($row_categoryType = mysqli_fetch_array($sql_categoryType)) { ?>
                                        <label class="ds__item">
                                            <input class="ds__item__input" type="radio" name="categoryType" value="<?php echo $row_categoryType['typeCa_name'] ?>">
                                            <span class="ds__item__label">
                                                <?php echo $row_categoryType['typeCa_name'] ?>
                                            </span>
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                        <li class="list-sidebar-item">
                            <p class="title-sidebar-item mt-3 mb-3">
                                Size
                                <span class="icon-plus">
                                    <i class="fa-solid fa-angle-down"></i>
                                </span>
                            </p>
                            <div class="sidebarSub Sub-size">
                                <label>
                                    <input class="field-cat" type="radio" value="S" name="size">
                                    <span class="d-flex">S</span>
                                </label>
                                <label>
                                    <input class="field-cat" type="radio" value="M" name="size">
                                    <span class="d-flex">M</span>
                                </label>
                                <label>
                                    <input class="field-cat" type="radio" value="L" name="size">
                                    <span class="d-flex">L</span>
                                </label>
                                <label>
                                    <input class="field-cat" type="radio" value="XL" name="size">
                                    <span class="d-flex">XL</span>
                                </label>
                                <label>
                                    <input class="field-cat" type="radio" value="XXL" name="size">
                                    <span class="d-flex">XXL</span>
                                </label>
                            </div>
                        </li>
                        <li class="list-sidebar-item">
                            <p class="title-sidebar-item mt-3 mb-3">
                                Màu Sắc
                                <span class="icon-plus">
                                    <i class="fa-solid fa-angle-down"></i>
                                </span>
                            </p>
                            <div class="sidebarSub Sub-color">
                                <div class="d-flex container-color">
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Vàng">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Vàng">
                                            <img src="./assets/img/Color/color1.png" title="Vàng">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Xanh">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Xanh matcha">
                                            <img src="./assets/img/Color/color2.png" title="Xanh matcha">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Hồng">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Hồng nhạt">
                                            <img src="./assets/img/Color/color3.png" title="Hồng nhạt">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Đỏ">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Đỏ">
                                            <img src="./assets/img/Color/color4.png" title="Đỏ">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Tím">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Tím">
                                            <img src="./assets/img/Color/color5.png" title="Tím">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Trắng">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Trắng">
                                            <img src="./assets/img/Color/color6.png" title="Trắng">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li class="list-sidebar-item">
                            <p class="title-sidebar-item mt-3 mb-3">
                                Mức Giá
                                <span class="icon-plus">
                                    <i class="fa-solid fa-angle-down"></i>
                                </span>
                            </p>
                            <div class="Sub-range">
                                <div class="container-range">
                                    <div id="slider-range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                        <div class="ui-slider-range ui-corner-all ui-widget-header">
                                        </div>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default">
                                        </span>
                                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                                    </div>
                                    <div class="value-range">
                                        <input type="hidden" name="product_price_from" value="0">
                                        <input type="hidden" name="product_price_to" value="0">
                                        <div id="amout-from">1.113.426đ</div>
                                        <div id="amout-to">6.259.259đ</div>
                                    </div>
                                </div>
                            </div>
                        </li>



                    </ul>
                    <div class="container-filter">
                        <div class="col-md-12 p-0" style="margin-top: 30px">
                            <div class="row m-0 p-0">
                                <div class="col-6">
                                    <button type="button" onclick="clearFilters()" class="btn btn--large btn--outline but_filter_remove" style="font-size: 13px;padding: 10px 20px;">Bỏ lọc</button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" name="filter" class="btn btn--large but_filter_product" style="font-size: 13px;padding: 10px 20px;">Lọc</button>
                                </div>
                            </div>
                            <p class="required" id="msg_error_size_color"></p>
                        </div>
                    </div>

                </form>
            </div>
            <div class="main-prod col-md-9 col-lg-9">
                <div class="top-main-prod d-flex">
                    <h3 class="sub-title-main">
                        KẾT QUẢ TÌM KIẾM THEO'
                        <?php echo $title ?>'
                    </h3>

                    <div class="choose-select">
                        <p class="d-flex" onclick="toggleSubChoose()">Sắp xếp theo
                            <span class="icon-down"><i class="fa-solid fa-angle-down"></i></span>
                        </p>
                        <div class="sub-choose" id="subChoose">
                            <ul class="sub-choose__list">
                                <li>
                                    <form action="" method="post">
                                        <input type="hidden" name="sort" value="default">
                                        <button class="button-sort" type="submit">Mặc định</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="" method="post">
                                        <input type="hidden" name="sort" value="name-az">
                                        <button class="button-sort" type="submit">Theo Tên : A-Z</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="" method="post">
                                        <input type="hidden" name="sort" value="name-za">
                                        <button class="button-sort" type="submit">Theo Tên : Z-A</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="" method="post">
                                        <input type="hidden" name="sort" value="price-high">
                                        <button class="button-sort" type="submit">Giá: cao đến thấp</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="" method="post">
                                        <input type="hidden" name="sort" value="price-low">
                                        <button class="button-sort" type="submit">Giá: thấp đến cao</button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <?php if (!empty($message)) : ?>
                    <div class="message">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <div class="sub-main-prod">
                    <div class="list-products-cat">
                        <div class="card-container" id="product-girl">
                            <div class="list-product__cartegory">
                                <?php
                                while ($row_product_cate = mysqli_fetch_array($sql_search)) {
                                ?>
                                    <div class="product-card product-cartegory">
                                        <a href="?quanly=product_Details&id=<?php echo $row_product_cate['product_id'] ?>">
                                            <!-- <div class="info-ticket ticket-news">NEW</div> -->
                                            <img src="./upload/img/Product/<?php echo $row_product_cate['img1_product'] ?>" class="card-img-top" alt="...">
                                            <img src="./upload/img/Product/<?php echo $row_product_cate['img2_product'] ?>" class="card-img-top hover-img-card" alt="...">
                                        </a>
                                        <div class="card-body">
                                            <div class="list-color">
                                                <span class="text-dark font-weight-bolder">Màu Sắc: </span>
                                                <div class="color-item mr-5">
                                                    <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="<?php echo $row_product_cate['product_color'] ?>">
                                                        <img class="w-50 h-50" src="./upload/img/Color/<?php echo $row_product_cate['product_color'] ?>.png" title="...">
                                                        <span class="tooltip"><?php echo $row_product_cate['product_color'] ?></span>
                                                    </span>
                                                </div>
                                                <div class="favourite">
                                                    <i class="fa-regular fa-heart"></i>
                                                </div>
                                            </div>
                                            <a href="?quanly=product_Details&id=<?php echo $row_product_cate['product_id'] ?>">
                                                <p class="card-text"><small>
                                                        <?php echo $row_product_cate['product_name'] ?>
                                                    </small>
                                                </p>
                                            </a>
                                            </p>
                                            <div class="rice-product">
                                                <h5 class="card-title">
                                                    <?php echo number_format($row_product_cate['product_rice'], 0, '.', '.') . 'đ'; ?>
                                                </h5>
                                                <form action="?quanly=cart" method="post">
                                                    <div class="add-to-cart">
                                                        <a href="#" class="cart-icon">
                                                            <i class="fa-solid fa-cart-shopping"></i>
                                                        </a>
                                                    </div>
                                                    <div class="list-size open-size">
                                                        <ul>
                                                            <li><button type="submit" class="btn bt-large">S</button></li>
                                                            <li><button type="submit" class="btn bt-large">M</button></li>
                                                            <li><button type="submit" class="btn bt-large">L</button></li>
                                                            <li><button type="submit" class="btn bt-large">XL</button></li>
                                                            <li><button type="submit" class="btn bt-large">XXL</button></li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" <?php if (!empty($message)) : ?>style="display: none;" <?php endif; ?>>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link page-link__n" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">Trang Cuối</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>