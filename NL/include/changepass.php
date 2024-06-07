<?php
$client_id = $_SESSION['user_id_client'];
// print_r($client_id);
$client_info = mysqli_query($conn, "SELECT * FROM account WHERE client_id = '$client_id'");
$row_client_info = mysqli_fetch_assoc($client_info);
$passCur = $row_client_info['user_pass'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pass = $_POST['pass'];
    $newPass = $_POST['newPassword'];
    $confirmPass = $_POST['confirmPassword'];
    // print_r($pass);

    if (!empty($pass) && !empty($newPass) && !empty($confirmPass)) {
        if ($pass === $passCur) {
            if ($newPass === $confirmPass) {
                $update_pass = mysqli_query($conn, "UPDATE account SET user_pass = '$newPass' WHERE client_id = '$client_id'");
                $successMessage = "Đổi mật khẩu thành công";
            } else {
                $errorMessage = "Xác nhận mật khẩu không đúng";
            }
        } else {
            $errorMessage = "Mật khẩu hiện tại không đúng";
        }
    } else {
        $errorMessage = "Vui lòng điền đầy đủ thông tin";
    }
}
?>

<main class="">
    <div class="row" style="margin: 0; justify-content: space-between; ">
        <div class="mb-5 py-3 bg-white rounded left-info" style="width: 330px; height: 100%;">
            <ul>
                <li><a href="index.php?quanly=infoclient">Tài khoản</a></li>
                <li><a href="index.php?quanly=processing">Đơn hàng đang xử lý</a></li>
                <li><a class="active" href="index.php?quanly=changepass">Đổi Mật Khẩu</a></li>
                <li><a onclick="handleLogout(event)" href="">Đăng xuất</a></li>
            </ul>
        </div>
        <form action="" method="post" class="p-3 mb-5 py-3 bg-white rounded  right-info" style="width: 1150px;">
            <section>
                <div class="row">
                    <h4 class="col-md-6">Đổi Mật Khẩu</h4>
                </div>
                <div class="form-group">
                    <label for="currentPassword">Mật khẩu hiện tại:</label>
                    <input type="password" class="form-control" id="currentPassword" name="pass" placeholder="Nhập mật khẩu hiện tại">
                </div>
                <div class="form-group">
                    <label for="newPassword">Mật khẩu mới:</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Nhập mật khẩu mới">
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Xác nhận mật khẩu mới:</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Xác nhận mật khẩu mới">
                </div>
            </section>
            <div>
                <input name="changePass" type="submit" class="btn btn-primary" value="Cập Nhật">
            </div>
        </form>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (isset($successMessage)) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: '<?php echo $successMessage; ?>',
        }).then(function() {
            window.location.href = 'http://localhost/NL/index.php?quanly=infoclient';
        });
    <?php } elseif (isset($errorMessage)) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: '<?php echo $errorMessage; ?>',
        });
    <?php } ?>
</script>