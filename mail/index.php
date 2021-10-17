<?php
if (!isset($_SESSION['signupOK'])) {
    header("Location:../admin/signup.php");
}
?>
<?php
//* include required phpmailer files
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';
//* define namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function sendemail($email, $name, $pass, $code)
{
    $mail = new PHPMailer(true); //* Create instance of phpmailer

    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP(); //* set mailer to use smtp
        $mail->Host = 'smtp.gmail.com'; //* define smtp host
        $mail->SMTPAuth = 'true'; //* enable smtp authentication
        $mail->SMTPSecure = 'tls'; //* set type of encryption (ssl, tls)
        $mail->Port = '587'; //* set post to connect smtp
        $mail->Username = ''; //* set gmail username
        $mail->Password = ''; //* set gmail pass
        $mail->CharSet = 'UTF-8'; //* set vietnamese
        //Recipients
        //* set sender email
        $mail->setFrom('phuxxx@gmail.com', 'Nguyễn Văn Phú');
        //* add recipient
        $mail->addAddress("$email"); //! variable must in ""
        //* Set email format to HTML
        $mail->isHTML(true);
        //* set email subject
        $mail->Subject = '[Đăng ký tài khoản Phonebook]';
        //* mail body
        $bodyContent = '<p>Thân gửi: ' . $name . '</p>';
        $bodyContent .= '<p>Chúc mừng bạn đã đăng ký thành công</p>';
        $bodyContent .= 'Nhấp vào đây để kích hoạt: <a href="http://localhost/test/session/activation.php?email=' . $email . '&code=' . $code . '">Nhấp vào đây</a>';
        $bodyContent .= '<p>mật khẩu của bạn là ' . $pass . '</p>';

        $mail->Body = $bodyContent;
        //* add data to database & send email
        if ($mail->send()) {
            echo "đăng ký thành công kiểm tra email<br>";
            echo '<a href="../index.php" class="btn btn-primary">Quay lại trang đăng nhập</a>';
        } else {
            echo "đăng kí không thành công";
        }
        //* close smtp connection
        $mail->smtpClose();
        //* unset session
        if (isset($_SESSION['signupOK'])) {
            unset($_SESSION['signupOK']);
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
