<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

?>
<header>
    <div class="navbar">
        <div class="container-navbar">
            <div class="left-navbar">
                <ul class="list-navbar__item">
                    <?php
                    $sql_category = mysqli_query($conn, 'SELECT * FROM category_list ORDER BY category_id ASC');
                    $counter = 1;
                    while ($row_category = mysqli_fetch_array($sql_category)) {
                    ?>
                        <li>                            
                            <a class="first-navbar item-menu <?php if ($counter === 4)
                                                                    echo 'fourth-menu'; ?>" href="?quanly=category&id=<?php echo $row_category['category_id'] ?>">
                                <?php echo $row_category['category_name'] ?>
                            </a>
                            <ul class="sub-menu">
                                <div class="list-submenu">
                                    <?php
                                    $sql_category_type = mysqli_query($conn, 'SELECT * FROM category_type, category_list
                WHERE category_type.category_id=category_list.category_id   
                AND category_type.category_id=' . $row_category['category_id'] . ' 
                ORDER BY typeCa_id ASC');
                                    while ($row_category_type = mysqli_fetch_array($sql_category_type)) {
                                    ?>
                                        <div class="item-list-submenu">
                                            <h3><a href="?quanly=category&idtype=<?php echo $row_category_type['typeCa_id'] ?>&id=<?php echo $row_category_type['category_id'] ?>">
                                                    <?php echo $row_category_type['typeCa_name'] ?>
                                                </a></h3>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </ul>
                        </li>
                    <?php
                        $counter++;
                    }
                    ?>
                    <li>LIFESTYLE</li>
                    <li>
                        <a class="six-navbar item-menu" href="#">VỀ CHÚNG TÔI</a>
                        <ul class="sub-menu sub-menu__six">
                            <li><a href="#">Về IVY moda</a></li>
                            <li><a href="#">Fashion Show</a></li>
                            <li><a href="#">Hoạt động cộng đồng</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="center-navbar">
                <div class="container-logo">
                    <a href="index.php"><img class="logo-header" src="./assets/img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="right-navbar">
                <div class="box-search">
                    <form action="index.php?quanly=category" id="search_form" method="post">
                        <button class="submit-boxsearch" name="search_button" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <!-- <input type="hidden" id="search_keyword" name="search_keyword"> -->
                        <div class="container-input__Search">
                            <input class="input-boxSearch" id="search_keyword" name="search_keyword" placeholder="TÌM KIẾM SẢN PHẨM">
                        </div>
                        <div class="quick-search">
                            <div class="item-searchs">
                                <h4>Tìm kiếm nhiều nhất</h4>
                                <div class="item-side-size">
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Đầm')">Đầm</a>
                                    </label>
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Áo công sở')">Áo
                                            công sở</a>
                                    </label>
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Chân váy')">Chân
                                            váy</a>
                                    </label>
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Quần suông')">Quần
                                            suông</a>
                                    </label>
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Áo sơ mi')">Áo sơ
                                            mi</a>
                                    </label>
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Polo')">Polo</a>
                                    </label>
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Hoodie')">Hoodie</a>
                                    </label>
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Skinny')">Skinny
                                        </a>
                                    </label>
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Áo công Vest')">Vest</a>
                                    </label>
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Baggy')">Baggy</a>
                                    </label>
                                    <label class="item-sub-list po-relative mb-2">
                                        <a href="#" class="item-sub-title" onclick="searchByKeyword('Tay lửng')">Tay
                                            lửng</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="other-function">
                    <div class="item-other">
                        <?php if (isset($_SESSION['login_client'])) : ?>
                            <a href="index.php?quanly=infoclient"><i class="fa-solid fa-user"></i></a>
                        <?php else : ?>
                            <a class="title-login " href="?quanly=login">
                                <i class="fa-solid fa-right-to-bracket"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="item-other">
                        <a href="?quanly=cart">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                        <?php $sql_get_cart = mysqli_query($conn, "SELECT SUM(cart_quantity) AS number_cart FROM cart_list WHERE client_id = '$client_id'");
                        $row = mysqli_fetch_assoc($sql_get_cart); ?>
                        <span id="number-cart" class="number-cart">
                            <?php echo $row['number_cart'] != 0 ? $row['number_cart'] : '0'; ?>
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
<script>
    function searchByKeyword(keyword) {
        document.getElementById('search_keyword').value = keyword;
        // document.getElementById('title_value').value = keyword;
        document.getElementById('search_form').submit(); // Gửi sự kiện submit cho biểu mẫu
    }
</script>
