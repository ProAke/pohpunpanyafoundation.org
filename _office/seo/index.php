<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :28/02/2565
Author : worapot pilabut (aj.ake)
E-mail : worapot.playdigital@gmail.com
Website : https://conenct.playdigital.co.th
Copyright (C) 2023, Play digital Co.,Ltd. all rights reserved.
 *****************************************************************/


include_once("../../include/config.inc.php");
include_once("../../include/class.inc.php");
include_once("../../include/class.TemplatePower.inc.php");
include_once("../../include/function.inc.php");
include_once("../authentication/check_login.php");



$tpl = new TemplatePower("../template/_tp_inner.html");
$tpl->assignInclude("body", "_tp_index.html");
$tpl->prepare();
// $tpl->assign("_ROOT.page_title", "หน้าแรก");
// $tpl->assign("_ROOT.logo_brand_alt", $Brand);


// $TodayThaiShow = ThaiToday($strDateTime, $tnow);
##########
$menu2 = '3';
$query = "SELECT * FROM `$tableAdminMenu` WHERE `ID` = '".$menu2."' AND `SHOW` = '0' ";
$result = $conn->query($query);
while ($line = $result->fetch_assoc()) {
	$tpl->assign("_ROOT.backend_menu",$line['MENU']);
}
GetMenuAdmin($menu2);
if($_SESSION['lag']==''){$_SESSION['lag']='1';}
if($_POST['language']!=""){$_SESSION['lag'] = $_POST['language'];}
BACKLANGUAGE($_SESSION['lag']);
##########

	$query = "SELECT * FROM `$tablePageDetail` WHERE `LAG` = '".$_SESSION['lag']."' ORDER BY `ID` ASC ";
	$result = $conn->query($query);
	// $line = $result->fetch_assoc();
	while($line = $result->fetch_assoc()){
		// echo $line['ID'];
		$no++;
		$tpl->newBlock("DATA");
		$tpl->assign("no",$no);
		$tpl->assign("id",$line['ID']);
		$tpl->assign("page",$line['PAGE']);
	}






// print_r($line);




// $tpl->assign("_ROOT.Powerby", $Powerby);
// $tpl->assign("_ROOT.Copyright", $Copyright);
$tpl->printToScreen();

