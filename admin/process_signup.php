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
$sql = "SELECT * FROM db_users where user_email ='$user_email'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo "Email đã tồn tại vui lòng thử lại<br>";
    echo '<a class="btn btn-primary" href="../admin/signup.php">Quay lại trang đăng ký</a>';
} else {
    $sql = "INSERT INTO db_users (user_name, user_email, user_pass) VALUES ('$user_name','$user_email', '$user_pass')";
    $result = mysqli_query($conn, $sql);
    if ($result > 0) {
        $_SESSION['signupOK'] = $user_email;
        header('location:../mail/index.php?email=' . $user_email . '&name=' . $user_name . '&pass=' . $user_pass);
    } else {
        echo "lỗi sql<br>";
    }
    mysqli_close($conn);
}
mysqli_close($conn);

include '../footer.php';
