<?php
session_start();

// Xóa tất cả các session
session_unset();

// Chuyển hướng về trang index.php
header('Location: ../index.php');
exit;
?>
