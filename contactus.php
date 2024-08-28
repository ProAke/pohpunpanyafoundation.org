<?php error_reporting(E_ALL ^ E_NOTICE);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");
require_once "./sendmail/vendor/autoload.php";



$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "template/_tp_contactus.html");
$tpl->prepare();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['g-recaptcha-response'])) {

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $secret = '6Ld98KIoAAAAAA2sOcliwan8MXDxtDCTJKGKN70R';
        $res = $_POST['g-recaptcha-response'];
        // $res = $_POST['res'];
        
        $v = file_get_contents($url . '?secret=' . $secret . '&response=' . $res);
        $v = json_decode($v);
        
        if( isset( $v->score ) ) {
            if ( $v->score >= 0.5 ) {
                // var_dump( $v );
                // echo "<div>การใช้งานถูกต้อง recaptcha ทำงาน</div>";

                


                if(($_POST['email']!='')&&($_POST['fname']!='')&&($_POST['detail']!='')){


					$ip = getenv('HTTP_CLIENT_IP')?:
					getenv('HTTP_X_FORWARDED_FOR')?:
					getenv('HTTP_X_FORWARDED')?:
					getenv('HTTP_FORWARDED_FOR')?:
					getenv('HTTP_FORWARDED')?:
					getenv('REMOTE_ADDR');				
					setlocale(LC_TIME, 'th_TH.utf-8');
					$dateTimeThai = strftime('%A %e %B %Y %H:%M:%S');	
					$url = $_SERVER['HTTP_REFERER'];


					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$email = $_POST['email'];
					$phone = $_POST['phone'];
					$detail = $_POST['detail'];

					$arrData = array();
					$arrData['FNAME'] = $fname;
					$arrData['LNAME'] = $lname;
					$arrData['EMAIL'] = $email;
					$arrData['PHONE'] = $phone;
					$arrData['MESSAGE'] = $detail;
					$arrData['DAY'] = date("Y-m-d H:i:s");
					$sql = sqlCommandInsert($tableMailMessage,$arrData);
					$query = $conn->query($sql);

					$from = "".$email;
					$to = "info@pohpunpanyafoundation.org";
					$subject = "Contact from pohpunpanyafoundation.org";
					$message = "".$detail;
					$headers = "From:" . $email;
					//mail($to,$subject,$message, $headers);


					


					
					$FromEmail      = $email;
					$FromFullName   = $fname." ".$lname;
					$FromMessage    = "คุณ ".$FromFullName." <br>เบอร์โทร : ".$_POST['phone'];
					$FromMessage    = $FromMessage."<br>";
					$FromMessage    = $FromMessage.$detail;
					$FromMessage    = $FromMessage."<br>";
					$FromMessage    = $FromMessage."----------------------------------";
					$FromMessage    = $FromMessage."<br> ข้อมูลผู้ส่ง : ".$ip. " เวลา : ". $dateTimeThai;
			
					$mail = new PHPMailer(true);
					
						$mail->SMTPDebug = 0;
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
						$tpl->newBlock("SUCCESSFUL");
					}else{
					
						$tpl->newBlock("SERROR");   
					}
	
					
				}else{
					$tpl->newBlock("FERROR");	
				}
            } else {
				$tpl->newBlock("ERROR");
            }   
        }     
    }



##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########



FRONTPAGESEO('5',$_SESSION['lag']);
$tpl->printToScreen();

