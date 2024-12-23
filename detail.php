<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master.html");







if($_GET['id']=='pao'){
	$tpl->assignInclude("body", "template/_tp_pao-project-brand.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนปัวเนยถั่วมะมื่น แบรนด์มะมื่นบัตเตอร์");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
}elseif($_GET['id']=='changes'){
	$tpl->assignInclude("body", "template/_tp_changes-in-the-learning-process-teaching-to-make-it-happen.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "การเปลี่ยนแปลงกระบวนการเรียน การสอนให้เกิดขึ้นจริง");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
}elseif($_GET['id']=='stories'){
	$tpl->assignInclude("body", "template/_tp_stories-from-teachers-and-students-of-the-wisdom-cultivation-project-year-1.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "การเปลี่ยนแปลงกระบวนการเรียน การสอนให้เกิดขึ้นจริง");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
}elseif($_GET['id']=='help'){
	$tpl->assignInclude("body", "template/_tp_help-narap-school.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "&quot; ไม่ทิ้งกัน &quot;");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
}elseif($_GET['id']=='pohpanpunya'){
	$tpl->assignInclude("body", "template/_tp_pohpanpunya-project.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "&quot;เพาะพันธุ์ปัญญาแคมป์&quot;");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
}elseif($_GET['id']=='newgentbiz'){
	$tpl->assignInclude("body", "template/_tp_newgentbiz.html");  /* แก้ไขแล้ว */
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ถอดประสบการณ์ก้าวแรก &quot;นักธุรกิจรุ่นเยาว์&quot;");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);

}elseif($_GET['id']=='pohpunpanya67'){
	$tpl->assignInclude("body", "template/_tp_pohpunpanya67.html"); /* แก้ไขแล้ว */
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "เพาะพันธุ์ปัญญาแคมป์ รุ่นปี 2567 เพิ่มความเข้มข้นในทุกมิติ มุ่งสร้างการเรียนรู้การทำธุรกิจเสมือนจริง");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
}elseif($_GET['id']=='missionyoungbiz'){
	$tpl->assignInclude("body", "template/_tp_pohpunpanya-mission-young-biz.html"); /* แก้ไขแล้ว */
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "เพาะพันธุ์ปัญญาแคมป์ รุ่นปี 2567 กับภารกิจปลุกปั้นเยาวชนนักธุรกิจสู่บ้านเกิด");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
}else{

	header('Location: /404');
	exit(0);
}






##########

if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);

##########


FRONTPAGESEO('4',$_SESSION['lag']);

$tpl->printToScreen();

?>