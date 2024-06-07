<?php
if (isset($_POST['signUp'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if ($username == '' || $password == '' || $email == '' || $phone == '' || $address == '') {
        echo '<script>Swal.fire("Lỗi", "Thiếu thông tin đăng Ký", "error");</script>';
    } else {
        // Check if email already exists
        $checkEmailQuery = mysqli_query($conn, "SELECT user_email FROM account WHERE user_email = '$email'");
        if (mysqli_num_rows($checkEmailQuery) > 0) {
            echo '<script>Swal.fire("Lỗi", "Email đã tồn tại", "error");</script>';
        } else {
            $sql_add_client = mysqli_query(
                $conn,
                "INSERT INTO client (client_name, client_phone, client_address) VALUES ('$username', '$phone', '$address')"
            );
            $sql_id = mysqli_insert_id($conn);
            $sql_add_user = mysqli_query(
                $conn,
                "INSERT INTO account (client_id, user_email, user_pass) VALUES ('$sql_id', '$email', '$password')"
            );
            echo '
            <script>
            Swal.fire("Thành Công", "Đăng Ký Thành Công", "success").then(function() {
              window.location.href = "?quanly=login";
            });
          </script>
          ';
        }
    }
}
?>
<main>
    <div class="container my-auto">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-6 mx-auto border-right">
                <div class="">
                    <div class="">
                        <div class="">
                            <h4 class="text-dark font-weight-bolder text-center mt-2 mb-0">Đăng ký tài khoản IVY MODA</h4>
                        </div>
                    </div>
                    <div class="">
                        <form role="form" action="" method="post" class="text-start">
                            <div class="input-group input-group-outline my-3">
                                <input type="text" name="username" class="form-control" placeholder="Tên của bạn">
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="input-group input-group-outline mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <input type="text" name="phone" class="form-control" placeholder="SDT">
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <input type="text" name="address" class="form-control" placeholder="Địa chỉ">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="signUp" class="btn btn--large but_filter_product p-3 w-100 font-weight-bolder">Đăng Ký</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>