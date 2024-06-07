<?php
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == '' || $password == '') {
        echo '<script>Swal.fire("Lỗi", "Không được để trống", "error");</script>';
    } else {

        $sql_select_login = mysqli_query($conn, "SELECT *, client.client_id AS id FROM account JOIN client ON client.client_id = account.client_id WHERE user_email = '$username' AND user_pass = '$password' LIMIT 1");
        $count_login = mysqli_num_rows($sql_select_login);
        $row_login = mysqli_fetch_assoc($sql_select_login);



        $type  = isset($row_login['user_type']) ? $row_login['user_type'] : '2';

        if ($count_login > 0 && $type !=2) {
            $_SESSION['login'] = $row_login['client_name'];
            $_SESSION['user_id'] = $row_login['id'];
            echo '
            <script>
              Swal.fire({
                title: "Thành Công",
                text: "Đăng Nhập Thành Công",
                icon: "success",
                showConfirmButton: false,
                timer: 2000
              }).then(function() {
                window.location.href = "./admin/pages/home.php";
              });
            </script>';
            // header("Location: ./admin/pages/home.php");
        } else if ($count_login > 0 && $type == 2) {
            $_SESSION['login_client'] = $row_login['client_name'];
            $_SESSION['user_id_client'] = $row_login['id'];
            // echo $type;

            echo '
            <script>
            Swal.fire({
                title: "Thành Công",
                text: "Đăng Nhập Thành Công",
                icon: "success",
                showConfirmButton: false,
                timer: 22000
            }).then(function() {
                window.location.href = "./index.php";
            });
            </script>';
        } else {

            echo '
       <script>Swal.fire("Lỗi", "Sai thông tin đăng nhập", "error");</script>';
        }
    }
}
?>
<main>
    <div class="container my-auto">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-6 mx-auto border-right">
                <div class="mx-5">
                    <div class="">
                        <div class="">
                            <h4 class="text-dark font-weight-bolder text-center mt-2 mb-0">Bạn đã có tài khoản IVY</h4>
                            <p class="text-center text-muted">Nếu bạn đã có tài khoản, hãy đăng nhập để tích lũy điểm thành viên và nhận được những ưu đãi tốt hơn!</p>
                        </div>
                    </div>
                    <div class="">
                        <form role="form" action="" method="post" class="text-start m-4">
                            <div class="input-group input-group-outline my-3">
                                <input type="email" name="username" class="form-control p-4" placeholder="Email">
                            </div>
                            <div class="input-group input-group-outline mb-3">
                                <input type="password" name="password" class="form-control p-4" placeholder="Mật Khẩu">
                            </div>
                            <div class="text-center">
                                <button type="submit" id="loginButton" name="login" class="btn btn--large but_filter_product p-3 w-100 font-weight-bolder">Đăng Nhập</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-6 mx-auto">
                <div class="mx-5">
                    <div class="mb-3">
                        <h4 class="text-dark font-weight-bolder text-center mt-2 mb-3">Khách hàng mới của IVY moda</h4>
                        <p class="text-center text-muted">Nếu bạn chưa có tài khoản trên ivymoda.com, hãy sử dụng tùy chọn này để truy cập biểu mẫu đăng ký.
                            Bằng cách cung cấp cho IVY moda thông tin chi tiết của bạn, quá trình mua hàng trên ivymoda.com sẽ là một trải nghiệm thú vị và nhanh chóng hơn!</p>
                    </div>
                    <div class="text-center">
                        <a href="?quanly=register" class="btn btn--large but_filter_product p-3 w-75 font-weight-bolder">Đăng Ký</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>