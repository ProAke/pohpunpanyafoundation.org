<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :20/01/2022
Author : worapot pilabut (pros.ake)
E-mail : worapot.bhi@gmail.com
# Index Check Session
 *****************************************************************/

 include_once("../include/config.inc.php");
 include_once("../include/class.inc.php");
 include_once("../include/class.TemplatePower.inc.php");
 include_once("../include/function.inc.php");
 include_once("../authentication/check_login.php");
 
 
 
 $tpl = new TemplatePower("../template/_tp_inner.html");
 $tpl->assignInclude("body", "_tp_profile.html");
 $tpl->prepare();
 $tpl->assign("_ROOT.page_title", "แก้ข้อมูลส่วนตัว");
 $tpl->assign("_ROOT.logo_brand_alt", $Brand);
 $tpl->assign("_ROOT.fullname",$_SESSION['FULLNAME']);
 
 
 
 
 
 
 
 
 
 
 $tpl->assign("_ROOT.Powerby", $Powerby);
 $tpl->assign("_ROOT.Copyright", $Copyright);
 $tpl->printToScreen();
 
 