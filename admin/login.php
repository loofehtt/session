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
        if (password_verify($user_pass, $pass_hash)) {
            $_SESSION['loginOK'] = $user_name;
            header("location: ./index.php");
        }
    } else {
        header("location: ../index.php");
    }
}
