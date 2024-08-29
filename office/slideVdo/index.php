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
$menu2 = '14';
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

// Change Sort------------------------------------------------------
if($_POST['action']=="sort" ){
	for($i=0;$i<count($_POST['order']);$i++){	
		if($_POST['id'][$i]!="" && $_POST['order']!=""){
			$id=$_POST['id'][$i];
			$sort=$_POST['order'][$i];
			$arrData = array();
			$arrData['ORDER'] = $sort;
			$query = sqlCommandUpdate($tableIndexSlideVdo,$arrData,"`ID`='$id'");
			$result = $conn->query($query);
		}
	}
	$tpl->assign("_ROOT.comment",'<span class="badge bg-yellow text-yellow-fg" style="margin-left: 10px;">อัพเดต Sort เรียบร้อยแล้ว</span>');
}

if($_GET['action']=='delete' && $_GET['id']!=''){
		$arrData = array();
		$arrData['DEL'] = '1';
		$sql = sqlCommandUpdate($tableIndexSlideVdo,$arrData," `ID` = ".$_GET['id']." ");
		$query = $conn->query($sql);	
	$tpl->assign("_ROOT.comment",'<span class="badge bg-yellow text-yellow-fg" style="margin-left: 10px;">ลบข้อมูลเรียบร้อยแล้ว</span>');
}
##########
	$query = "SELECT main.*,a.*
	FROM `$tableIndexSlideVdo` as main 
	LEFT JOIN `$tableIndexSlideVdoDetail` as a ON a.ID_SLIDE = main.ID ";
	$query .= " WHERE main.DEL = '0' AND a.LAG = '".$_SESSION['lag']."' ORDER BY main.ORDER DESC ";
	$result = $conn->query($query);

// echo $_SESSION['lag'];
// echo $query->num_rows;
	// $query = "SELECT * FROM `$tablePageDetail` WHERE `LAG` = '".$_SESSION['lag']."' ORDER BY `ID` ASC ";
	// $result = $conn->query($query);
	// $line = $result->fetch_assoc();
	while($line = $result->fetch_assoc()){
		// echo $line['ID'];
		$no++;
		$tpl->newBlock("DATA");
		$tpl->assign("no",$no);
		$tpl->assign("id",$line['ID']);
		$tpl->assign("order",$line['ORDER']);
		$tpl->assign("page",'<img src="../../upload/slideVdo/'.$line['BANNER_500'].'" height="200">');
	}






// print_r($line);




// $tpl->assign("_ROOT.Powerby", $Powerby);
// $tpl->assign("_ROOT.Copyright", $Copyright);
$tpl->printToScreen();

