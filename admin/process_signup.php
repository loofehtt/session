<?php
include '../header.php';
session_start();
if (isset($_POST['signup'])) {
    $user_name = $_POST['username'];
    $user_pass = $_POST['password'];
    $user_repass = $_POST['re_password'];
    $user_email = $_POST['email'];
} else {
    echo 'sai';
}
include '../config.php';
$sql = "SELECT * FROM db_users where user_email ='$user_email' or user_name = '$user_name'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo 'Email hoặc tên đăng nhập đã tồn tại vui lòng thử lại<br>';
    echo '<a class="btn btn-primary" href="../admin/signup.php">Quay lại trang đăng ký</a><br>';
    echo '<a href="../index.php" class="btn btn-primary">Quay lại trang đăng nhập</a>';
} else {
    //mã hoá password
    $pass_hash = password_hash($user_pass, PASSWORD_DEFAULT);
    $code = md5(uniqid(rand(), true));
    $sql = "INSERT INTO db_users (user_name, user_email, user_pass, user_code) VALUES ('$user_name','$user_email', '$pass_hash', '$code')";
    $result = mysqli_query($conn, $sql);
    if ($result > 0) {
        $_SESSION['signupOK'] = $user_email;
        include '../mail/index.php';
        sendemail($user_email, $user_name, $user_pass, $code);
    } else {
        echo "lỗi sql";
    }
}
mysqli_close($conn);

include '../footer.php';
