<main>

    <?php
    if (isset($_GET['id']) && !isset($_GET['idtype'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM category_list, product_list
    WHERE category_list.category_id = product_list.category_id 
    AND product_list.category_id = '$id'";
        $_SESSION['category_sort'] = $sql;

        // $sql_cate = mysqli_query($conn, $sql);

        $sql_cate_Title = mysqli_query($conn, "SELECT * FROM category_list, product_list
    WHERE category_list.category_id = product_list.category_id 
    AND product_list.category_id = '$id' ");
        $row_title = mysqli_fetch_array($sql_cate_Title);
        $title = $row_title['category_name'];
        $_SESSION['title'] = $title;
    } elseif (isset($_GET['id']) && isset($_GET['idtype'])) {
        $id = $_GET['id'];
        $idtype = $_GET['idtype'];

        $sql = "SELECT * FROM category_list, product_list, category_type
    WHERE category_list.category_id = product_list.category_id 
    AND category_type.typeCa_id = product_list.typeCa_id
    AND product_list.category_id = '$id' 
    AND category_type.typeCa_id = '$idtype'
    ORDER BY product_list.typeCa_id ASC";
        $_SESSION['category_sort'] = $sql;
        // $sql_cate = mysqli_query($conn, $sql);

        $sql_cate_link = mysqli_query($conn, "SELECT * FROM category_list, product_list, category_type
    WHERE category_list.category_id = product_list.category_id 
    AND category_type.typeCa_id = product_list.typeCa_id
    AND product_list.category_id = '$id' 
    AND category_type.typeCa_id = '$idtype'
    ORDER BY product_list.typeCa_id ASC");
        $row_link = mysqli_fetch_array($sql_cate_link);
        $title = $row_link['typeCa_name'];
        $title_cate = $row_link['category_name'];
        $_SESSION['title'] = $title;
    } else {
        $id = '';
        $idtype = '';
    }
    $keyWord = "";
    if (isset($_POST["search_keyword"]) || isset($_POST['search_button'])) {
        $keyWord = $_POST['search_keyword'];
        $sql = "SELECT * FROM product_list WHERE product_name LIKE '%$keyWord%'";
        $_SESSION['category_sort'] = $sql;
        // print_r($_SESSION['category_sort']);
        $_SESSION['title'] = $keyWord;
    }
    $productsPerPage = 10;

    // Tổng số sản phẩm
    $sql_page = $_SESSION['category_sort'];
    $row_page = mysqli_query($conn, $sql_page);
    $totalProducts = mysqli_num_rows($row_page);
    // print_r($totalProducts);

    // Tổng số trang
    $totalPages = ceil($totalProducts / $productsPerPage);

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

    $start = ($current_page - 1) * $productsPerPage;

    $sql_page .= " LIMIT $start, $productsPerPage";
    // print_r($sql_page);
    $_SESSION['category_sort'] = $sql_page;
    // Sắp Xếp
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

        // print_r($sql);
    }
    // print_r($sql);
    $sql_cate = mysqli_query($conn, $sql);

    // Số lượng sản phẩm trên mỗi trang

    ?>
    <section class="section-cartegory">
        <div class="breadcrumb-products">
            <ul class="breadcrumb__list d-flex">
                <li class="breadcrumb__item">
                    <a class="breadcrumb__link" href="index.php">Trang Chủ</a>
                </li>
                <li class="breadcrumb__item">
                    <a class="breadcrumb__link" href="#">
                        <?php if (isset($_GET['id']) && !isset($_GET['idtype'])) {
                            echo $title;
                        } elseif (isset($_GET['id']) && isset($_GET['idtype'])) {
                            echo $title_cate;
                        } ?>
                    </a>
                </li>
                <li class="breadcrumb__item">
                    <a class="breadcrumb__link not" href="#">
                        <?php if (isset($_GET['id']) && !isset($_GET['idtype'])) {
                            echo '';
                        } elseif (isset($_GET['id']) && isset($_GET['idtype'])) {
                            echo $title;
                        } ?>
                    </a>
                </li>
            </ul>
        </div>

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
                                            <img src="./upload/img/Color/Vàng.png" title="Vàng">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Cam">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Cam">
                                            <img src="./upload/img/Color/Cam.png" title="Cam">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Đen">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Đen">
                                            <img src="./upload/img/Color/Đen.png" title="Đen">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Đỏ">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Đỏ">
                                            <img src="./upload/img/Color/Đỏ.png" title="Đỏ">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Nâu">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Nâu">
                                            <img src="./upload/img/Color/Nâu.png" title="Nâu">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Hồng">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Hồng">
                                            <img src="./upload/img/Color/Hồng.png" title="Hồng">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Tím">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Tím">
                                            <img src="./upload/img/Color/Tím.png" title="Tím">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Trắng">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Trắng">
                                            <img src="./upload/img/Color/Trắng.png" title="Trắng">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Xám">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Xám">
                                            <img src="./upload/img/Color/Xám.png" title="Xám">
                                            <span class="tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Xanh Biển">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Xanh Biển">
                                            <img src="./upload/img/Color/Xanh Biển.png" title="Xanh Biển">
                                            <span class="tooltip extra-tooltip"></span>
                                        </span>
                                    </label>
                                    <label class="color-item">
                                        <input class="ds__item__input" type="radio" name="check_color" value="Xanh Lá">
                                        <span class="ds__item__label check-color" data-toggle="tooltip" data-original-title="Xanh Lá">
                                            <img src="./upload/img/Color/Xanh Lá.png" title="Xanh Lá">
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
                        <?php echo $_SESSION['title'] ?>
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
                <div class="sub-main-prod">
                    <div class="list-products-cat">
                        <div class="card-container" id="product-girl">
                            <div class="list-product__cartegory">
                                <?php
                                while ($row_product_cate = mysqli_fetch_array($sql_cate)) {
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
                                                    <span class="ds__item__label check-color mr-4" data-toggle="tooltip" data-original-title="<?php echo $row_product_cate['product_color'] ?>">
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
                                                <form class="cartForm" action="?quanly=cart" method="post">
                                                    <div class="add-to-cart">
                                                        <a href="#" class="cart-icon">
                                                            <i class="fa-solid fa-cart-shopping"></i>
                                                        </a>
                                                    </div>
                                                    <div class="list-size open-size">
                                                        <?php $product_id = $row_product_cate['product_id'];
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
                                                    <input type="hidden" name="product_id" value="<?php echo $row_product_cate['product_id'] ?>">
                                                    <input type="hidden" name="cart_name" value="<?php echo $row_product_cate['product_name'] ?>">
                                                    <input type="hidden" name="cart_rice" value="<?php echo $row_product_cate['product_rice'] ?>">
                                                    <input type="hidden" name="cart_img" value="<?php echo $row_product_cate['img1_product'] ?>">
                                                    <input type="hidden" name="cart_color" value="<?php echo $row_product_cate['product_color']; ?>">
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

                        </div>
                        <?php
                        // Giá trị trang hiện tại
                        $current_url = $_SERVER["REQUEST_URI"]; // Lấy đường dẫn hiện tại

                        // Thêm giá trị "page" vào query string
                        if (strpos($current_url, "?") !== false) {
                            // Đã tồn tại query string
                            $current_url .= "&page=" . $current_page;
                        } else {
                            // Chưa có query string
                            $current_url .= "?page=" . $current_page;
                        }
                        ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php if ($current_page > 1) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo $_SERVER['REQUEST_URI'] . '&page=' . ($current_page - 1); ?>" aria-label="Previous">Trang trước</a>
                                        <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                    <li class="page-item <?php echo ($current_page == $i) ? 'active' : ''; ?>">
                                        <a class="page-link  <?php echo ($current_page == $i) ? 'page-link__n' : ''; ?>" href="<?php echo $_SERVER['REQUEST_URI'] . '&page=' . $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($current_page < $totalPages) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo $_SERVER['REQUEST_URI'] . '&page=' . ($current_page + 1); ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <li class="page-item"><a class="page-link" href="<?php echo $_SERVER['REQUEST_URI'] . '&page=' . $totalPages; ?>">Trang Cuối</a></li>
                            </ul>
                        </nav>

                    </div>

                </div>

            </div>


        </div>

    </section>
    <script>
        const form = document.querySelector('form[action="?quanly=filter"]');
        const filterButton = form.querySelector('button[name="filter"]');

        filterButton.addEventListener('click', function(event) {
            const categoryType = form.querySelector('input[name="categoryType"]:checked');
            const size = form.querySelector('input[name="size"]:checked');
            const color = form.querySelector('input[name="check_color"]:checked');
            const priceFrom = form.querySelector('input[name="product_price_from"]');
            const priceTo = form.querySelector('input[name="product_price_to"]');

            if (!categoryType && !size && !color && priceFrom.value === '0' && priceTo.value === '0') {
                event.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Thông báo',
                    text: 'Vui lòng chọn ít nhất một thuộc tính để lọc!',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
    <script>
        function clearFilters() {

            $('input[name="categoryType"]').prop('checked', false);

            $('input[name="size"]').prop('checked', false);

            $('input[name="check_color"]').prop('checked', false);
            $('input[name="product_price_from"]').val('0');
            $('input[name="product_price_to"]').val('0');
            $('#amout-from').text('0đ');
            $('#amout-to').text('0đ');


        }
    </script>
</main>