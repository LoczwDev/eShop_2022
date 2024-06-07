<?php
include_once('library/connect.php');
session_start();
$login = isset($_SESSION['login_client']) ? $_SESSION['login_client'] : '';
$client_id = isset($_SESSION['user_id_client']) ? $_SESSION['user_id_client'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ | IVY moda</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body>
    <?php
    include("include/header.php");

    if (isset($_GET['quanly'])) {
        $getURL = $_GET['quanly'];
    } else {
        $getURL = "";
    }

    switch ($getURL) {
        case 'category':
            include("include/category.php");
            break;
        case 'register':
            include("include/register.php");
            break;
        case 'login':
            include("include/login.php");
            break;
        case 'product_Details':
            include("include/product_Details.php");
            break;
        case 'cart':
            include("include/cart.php");
            break;
        case 'cart_Step1':
            include("include/order.php");
            break;
        case 'thanks':
            include("include/thanks.php");
            break;
        case 'search':
            include("include/search.php");
            break;
        case 'infoclient':
            include("include/info.php");
            break;
        case 'processing':
        case 'order_client_view':
            include("include/processing.php");
            break;
        case 'filter':
            include("include/filter_products.php");
            break;
        case 'changepass':
            include("include/changepass.php");
            break;
        default:
            include("include/home.php");
            break;
    }

    include("include/footer.php");
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./assets/js/category.js"></script>
    <script src="./assets/js/main.js"></script>
    <script>
        const cartForms = document.querySelectorAll('.cartForm');

        cartForms.forEach((form) => {
            const sizeButtons = form.querySelectorAll('.select-size');
            const selectedSizeInput = form.querySelector('.selectedSizeInput');
            const maxQuantity = form.querySelector('.maxQuantity');

            sizeButtons.forEach((button) => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const loginSession = "<?php echo $login; ?>";
                    if (loginSession !== '') {
                        // event.preventDefault();
                        const selectedSize = this.value;
                        selectedSizeInput.value = selectedSize;

                        const maxQuantityInput = parseInt(this.dataset.quantity);
                        maxQuantity.value = maxQuantityInput;

                        Swal.fire({
                            icon: 'success',
                            title: 'Thao tác thành công!',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            // Submit form sau khi thông báo được hiển thị
                            form.submit();
                        });
                    } else {
                        event.preventDefault();
                        // Hiển thị thông báo lỗi nếu loginSession không tồn tại
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Vui lòng đăng nhập trước khi chọn kích thước.'
                        });
                    }
                });
            });
        });
    </script>

</body>

<script>
    $('.brand-extra').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: false,
        autoplay: true,
        setTimeout: 7000,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 2
            }
        }
    })
    $('.carousel-gallery').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: false,
        autoplay: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 5
            },
            1000: {
                items: 5
            }
        }
    })
</script>
<script>
    $('.carousel-Viewed__product').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        dots: false,
        autoplay: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 5
            },
            1000: {
                items: 5
            }
        }
    })
</script>




</html>