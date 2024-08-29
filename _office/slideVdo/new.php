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
include_once("../../include/thumbimage.class.php");
include_once("../authentication/check_login.php");



$tpl = new TemplatePower("../template/_tp_inner.html");
$tpl->assignInclude("body", "_tp_new.html");
$tpl->prepare();
// $tpl->assign("_ROOT.page_title", "หน้าแรก");
// $tpl->assign("_ROOT.logo_brand_alt", $Brand);

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

if($_POST['action']=='save'){
	
	$img = SaveUploadImg($_FILES['img'],"../../upload/slideVdo/");
	if($img){
		@unlink("../../upload/pages/img/".$_POST['imgold']);	

		$ex = explode(".", $img);

		if($ex[1]=='png'){
			$objThumbImage = new ThumbImagePNG("../../upload/slideVdo/".$img);
			$objThumbImage->createThumb("../../upload/slideVdo/".$ex[0]."_500.".$ex[1], 500);
			$objThumbImage->createThumb("../../upload/slideVdo/".$ex[0]."_800.".$ex[1], 800);
			$objThumbImage->createThumb("../../upload/slideVdo/".$ex[0]."_940.".$ex[1], 940);
		}elseif($ex[1]=='jpg'){
			$objThumbImage = new ThumbImageJPG("../../upload/slideVdo/".$img);
			$objThumbImage->createThumb("../../upload/slideVdo/".$ex[0]."_500.".$ex[1], 500);
			$objThumbImage->createThumb("../../upload/slideVdo/".$ex[0]."_800.".$ex[1], 800);
			$objThumbImage->createThumb("../../upload/slideVdo/".$ex[0]."_940.".$ex[1], 940);
		}
		
	}


	$query = "SELECT MAX(`ORDER`) FROM `$tableIndexSlideVdo` ";
	$result = $conn->query($query);
	$line = $result->fetch_assoc();
	$intMaxOrder = $line["MAX(`ORDER`)"]+1;

	$arrData = array();
	$arrData['PHOTO'] 	= $_POST['title'];
	$arrData['URL'] = $_POST['url'];
	$arrData['ORDER'] = $intMaxOrder;
	$query = sqlCommandInsert($tableIndexSlideVdo,$arrData);
	$result = $conn->query($query);
	$newId = $conn->insert_id;
	// echo $newId;
////////////////
	if($newId!=''){
		$arrData = array();
		$arrData['ID_SLIDE'] = $newId;
		$arrData['URL'] = $_POST['url'];
		$arrData['DETAIL'] = $_POST['detail'];
		$arrData['DATE'] = date("Y-m-d H:i:s");

		if($img != ""){
			$arrData['BANNER_NAME'] = $img;
			$arrData['BANNER_940'] = $ex[0]."_940.".$ex[1];
			$arrData['BANNER_800'] = $ex[0]."_800.".$ex[1];
			$arrData['BANNER_500'] = $ex[0]."_500.".$ex[1];
		}

		for ($i=1; $i <= COUNTLANGUAGE('') ; $i++) {
			$arrData['LAG'] = $i; 
			$sql = sqlCommandInsert($tableIndexSlideVdoDetail,$arrData);
			$query = $conn->query($sql);
		}
	}else{

	}

$tpl->assign("_ROOT.comment",'<span class="badge bg-yellow text-yellow-fg" style="margin-left: 10px;">บันทึกข้อมูลเรียบร้อยแล้ว</span>');

}


	$tpl->newBlock("DATA");


$tpl->printToScreen();

