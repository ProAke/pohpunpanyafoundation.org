<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once "vendor/autoload.php";

$ip = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');

setlocale(LC_TIME, 'th_TH.utf-8');
$dateTimeThai = strftime('%A %e %B %Y %H:%M:%S');

$url = $_SERVER['HTTP_REFERER'];
$FromEmail      = $_POST['email'];
$FromFullName   = $_POST['fname']." ".$_POST['lname'] ;
$FromMessage    = "คุณ ".$FromFullName." <br>เบอร์โทร : ".$_POST['phone'];
$FromMessage    = $FromMessage."<br>";
$FromMessage    = $FromMessage.$_POST['detail'];
$FromMessage    = $FromMessage."<br>";
$FromMessage    = $FromMessage."----------------------------------";
$FromMessage    = $FromMessage."<br> ข้อมูลผู้ส่ง : ".$ip. " เวลา : ". $dateTimeThai;

if($url==="https://dev.pohpunpanyafoundation.org/contactus"){


$mail = new PHPMailer(true);

    $mail->SMTPDebug = 1;
    $mail->isSMTP();
    $mail->Host = "smtp.mailersend.net";
    $mail->SMTPAuth = true;
    $mail->Username = "MS_RcIEZd@pohpunpanyafoundation.org";
    $mail->Password = "4UYJaxQiPIYqplbB";
    $mail->SMTPSecure = "tls"; // Change "tls" to "ssl"
    $mail->Port = 587;

    $mail->setFrom("MS_RcIEZd@pohpunpanyafoundation.org", "Website");
    $mail->addAddress("info@pohpunpanyafoundation.org", "Information Data");
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8'; // Set charset to UTF-8
    $mail->Subject = "ติดต่อจากเว็บไซต์ มูลนิธิเพาะพันธฺุ์ปัญญา ของ คุณ " . $FromFullName;
    $mail->Body = "<br>".$FromMessage;
    $mail->AltBody = "-";

if($mail->send()){
    header('Location: https://dev.pohpunpanyafoundation.org/contactus?status=successful');
    exit();
}else{

    header('Location: https://dev.pohpunpanyafoundation.org/contactus?status=error_mail');
    exit();    
}



}else{

    header('Location: https://dev.pohpunpanyafoundation.org/?status=404');
    exit();       
}





?>