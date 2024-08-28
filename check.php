<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master_error.html");
$tpl->assignInclude("body", "template/_tp_404.html");
$tpl->prepare();



// เตรียมคำสั่ง SQL
$query = "SELECT main.*,a.*
    FROM `$tableCampProvince` as main 
    LEFT JOIN `$tableCampProvinceDetail` as a ON a.ID_PROVINCE = main.ID
    WHERE main.STATUS = 'Show' AND main.ID_MODEL = '1' AND a.LAG = ? 
    ORDER BY main.ORDER ASC";

// ใช้ prepared statements
$stmt = $conn->prepare($query);

// ตรวจสอบว่า prepared statements ถูกสร้างขึ้นหรือไม่
if ($stmt === false) {
    die("การเตรียมคำสั่งล้มเหลว: " . $conn->error);
}else{
	echo "OK";
}


FRONTLANGUAGE(1);
//FRONTPAGESEO('1',1);

$tpl->printToScreen();
