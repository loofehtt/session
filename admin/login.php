<?php
session_start();

if (isset($_POST['login'])) {
    $user_name = $_POST['userName'];
    $user_pass = $_POST['userPass'];

    //Mở kết nối
    include '../config.php';

    //Truy vấn
    $sql = "SELECT * FROM db_users WHERE user_email = '$user_name' or user_name = '$user_name'";
    $result = mysqli_query($conn, $sql);

    //Xác thực
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $pass_hash = $row['user_pass'];
        $status = $row['user_status'];
        if (password_verify($user_pass, $pass_hash)) {
            if ($status == '0') {
                echo "tài khoản chưa được kích hoạt";
            } else {
                $_SESSION['loginOK'] = $user_name;
                header("location: ./index.php");
            }
        } else {
            echo "Mật khẩu không chính xác<br><br>";
            echo '<a href="../index.php">Quay lại trang đăng nhập</a>';
        }
    } else {
        echo "tài khoản không tồn tại<br><br>";
        echo '<a href="../index.php">Quay lại trang đăng nhập</a>';
    }
}
