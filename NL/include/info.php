<?php
$client_id = $_SESSION['user_id_client'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql_update_client = mysqli_query($conn, "UPDATE client 
    SET client_name = '$username', client_phone = '$phone', client_address = '$address' 
    WHERE client_id = '$client_id' ");
    $sql_update_account = mysqli_query($conn, "UPDATE account 
    SET user_email = '$email' WHERE client_id = '$client_id' ");
}
?>

<main class="">
    <div class="row" style="margin: 0; justify-content: space-between; ">
        <div class="mb-5 py-3 bg-white rounded left-info" style="width: 330px; height: 100%;">
            <ul>
                <li><a class="active" href="index.php?quanly=infoclient">Tài khoản</a></li>
                <li><a href="index.php?quanly=processing">Đơn hàng đang xử lý</a></li>
                <li><a href="index.php?quanly=changepass">Đổi Mật Khẩu</a></li>
                <li><a onclick="handleLogout(event)" href="">Đăng xuất</a></li>
            </ul>
        </div>
        <form action="" method="post" class="p-3 mb-5 py-3 bg-white rounded  right-info" style="width: 1150px;">
            <?php $client_info = mysqli_query($conn, "SELECT * FROM client JOIN account ON client.client_id = account.client_id WHERE client.client_id = '$client_id' ");

            $row_client_info = mysqli_fetch_assoc($client_info); ?>

            <section>
                <div class="row">
                    <h4 class="col-md-6" style="color: #4d96ff">Thông tin tài khoản</h4>
                    <a id="edit" class="col-md-6 d-flex justify-content-end " onclick="handlerEdit()" href="#">Thay Đổi Thông Tin</a>
                </div>

                <table class="table rounded w-100 p-5 ">
                    <thead>
                        <tr>
                            <th style="border-bottom: none;">Họ và Tên:</th>
                            <td>
                                <span class="spanInfo"><?php echo $row_client_info['client_name'] ?></span>
                                <input class="inputInfo form-control" style="display: none;" type="text" name="username" value="<?php echo $row_client_info['client_name'] ?>">
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Email</th>
                            <td>
                                <span class="spanInfo"><?php echo $row_client_info['user_email'] ?></span>
                                <input class="inputInfo form-control" style="display: none;" type="text" name="email" value="<?php echo $row_client_info['user_email'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>Số điện thoại</th>
                            <td>
                                <span class="spanInfo"><?php echo $row_client_info['client_phone'] ?></span>
                                <input class="inputInfo form-control" style="display: none;" type="text" name="phone" value="<?php echo $row_client_info['client_phone'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>Địa chỉ</th>
                            <td>
                                <span class="spanInfo"><?php echo $row_client_info['client_address'] ?></span>
                                <input class="inputInfo form-control" style="display: none;" type="text" name="address" value="<?php echo $row_client_info['client_address'] ?>">
                            </td>
                        </tr>
                    </tbody>
                </table>


            </section>
            <div>
                <input id="submitInfo" name="submitInfo" type="submit" style="display: none;" class="btn btn-primary" value="Cập Nhật">
            </div>
        </form>
    </div>
</main>
<script>
    function handlerEdit(event) {
        event.preventDefault();

        $('#submitInfo').show();
        $('.inputInfo').show();
        $('.spanInfo').hide();
    }

    $('#edit').click(handlerEdit);
</script>
