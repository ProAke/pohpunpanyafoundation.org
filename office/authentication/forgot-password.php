<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :20/01/2022
Author : worapot pilabut (pros.ake)
E-mail : worapot.bhi@gmail.com
# Index Check Session
 *****************************************************************/
include_once("../include/config.inc.php");
include_once("../include/function.inc.php");
include_once("../include/class.TemplatePower.inc.php");
$tpl = new TemplatePower("../template/_tp_login.html");
$tpl->assignInclude("body", "_tp_forgot-password.html");
$tpl->prepare();


$tpl->newBlock("ERROR");
$tpl->assign("strMessage", "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง");
$tpl->newBlock("FORM");
CheckLogin($_COOKIE[$cookie_name]);



$tpl->assign("_ROOT.page_title", "ระบบจัดการข้อมูลลูกค้า");
$tpl->printToScreen();
