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
$menu2 = '15';
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
// $TodayThaiShow = ThaiToday($strDateTime, $tnow);
if($_POST['action']=='save'){
	// echo $_FILES['img'];
	$img = SaveUploadImg($_FILES['img'],"../../upload/slideCamp/");
	if($img != ""){	

		$ex = explode(".", $img);

		if($ex[1]=='png'){
			$objThumbImage = new ThumbImagePNG("../../upload/slideCamp/".$img);
			$objThumbImage->createThumb("../../upload/slideCamp/".$ex[0]."_500.".$ex[1], 500);
			$objThumbImage->createThumb("../../upload/slideCamp/".$ex[0]."_800.".$ex[1], 800);
			$objThumbImage->createThumb("../../upload/slideCamp/".$ex[0]."_1080.".$ex[1], 1080);
			$objThumbImage->createThumb("../../upload/slideCamp/".$ex[0]."_1600.".$ex[1], 1600);
			$objThumbImage->createThumb("../../upload/slideCamp/".$ex[0]."_1920.".$ex[1], 1920);
		}elseif($ex[1]=='jpg'){
			$objThumbImage = new ThumbImageJPG("../../upload/slideCamp/".$img);
			$objThumbImage->createThumb("../../upload/slideCamp/".$ex[0]."_500.".$ex[1], 500);
			$objThumbImage->createThumb("../../upload/slideCamp/".$ex[0]."_800.".$ex[1], 800);
			$objThumbImage->createThumb("../../upload/slideCamp/".$ex[0]."_1080.".$ex[1], 1080);
			$objThumbImage->createThumb("../../upload/slideCamp/".$ex[0]."_1600.".$ex[1], 1600);
			$objThumbImage->createThumb("../../upload/slideCamp/".$ex[0]."_1920.".$ex[1], 1920);
		}

	}

	$arrData = array();
	$arrData['PHOTO'] 	= $_POST['title'];
	$arrData['URL'] = $_POST['url'];
	$query = sqlCommandUpdate($tableIndexSlideCamp,$arrData," ID = '".$_GET['id']."' ");
	$result = $conn->query($query);

	$arrData = array();
	$arrData['URL'] = $_POST['url'];
	if($img != ""){
		$arrData['BANNER_NAME'] = $img;
		$arrData['BANNER_1920'] = $ex[0]."_1920.".$ex[1];
		$arrData['BANNER_1600'] = $ex[0]."_1600.".$ex[1];
		$arrData['BANNER_1080'] = $ex[0]."_1080.".$ex[1];
		$arrData['BANNER_800'] = $ex[0]."_800.".$ex[1];
		$arrData['BANNER_500'] = $ex[0]."_500.".$ex[1];
	}
	$sql = sqlCommandUpdate($tableIndexSlideCampDetail,$arrData," `LAG` = '".$_SESSION['lag']."' AND ID_SLIDE = '".$_GET['id']."' ");
	$query = $conn->query($sql);

$tpl->assign("_ROOT.comment",'<span class="badge bg-yellow text-yellow-fg" style="margin-left: 10px;">บันทึกข้อมูลเรียบร้อยแล้ว</span>');

}

	$query = "SELECT main.*,a.*
	FROM `$tableIndexSlideCamp` as main 
	LEFT JOIN `$tableIndexSlideCampDetail` as a ON a.ID_SLIDE = main.ID ";
	$query .= " WHERE main.DEL = '0' AND a.LAG = '".$_SESSION['lag']."' AND main.ID = '".$_GET['id']."' ORDER BY main.ORDER DESC ";

	$result = $conn->query($query);
	if($result->num_rows==0){
	?>
	<script>alert("Cannot found this record, Could you please create new record");window.location.href="new.php";</script>
	<?php
	//exit;
	}	
	while($line = $result->fetch_assoc()){
		$no++;
		$tpl->newBlock("DATA");
		$tpl->assign("no",$no);
		$tpl->assign("id",$line['ID']);
		$tpl->assign("title",$line['PHOTO']);
		$tpl->assign("url",$line['URL']);

		if(is_file("../../upload/slideCamp/".$line['BANNER_500'])){
			$tpl->assign("img","<img src='../../upload/slideCamp/".$line['BANNER_500']."' height='150'>");
			$tpl->assign("imgold",$line['BANNER_NAME']);
			$tpl->assign("remove1","<a href='?id=".$line['ID']."&ac=remove1&file1=".$line['BANNER_NAME']."'> Remove image </a>");
		}

	}

// echo COUNTLANGUAGE($id);

$tpl->printToScreen();

