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
$tpl->assignInclude("body", "_tp_new.html");
$tpl->prepare();
$tpl->assign("_ROOT.page_title", "หน้าแรก");
$tpl->assign("_ROOT.logo_brand_alt", $Brand);

##########
if($_SESSION['lag']==''){$_SESSION['lag']='1';}
if($_POST['language']!=""){$_SESSION['lag'] = $_POST['language'];}
BACKLANGUAGE($_SESSION['lag']);
##########
// $TodayThaiShow = ThaiToday($strDateTime, $tnow);
if($_POST['action']=='save'){

	$keyimg = SaveUploadImg($_FILES['keyimg'],"../../upload/pages/img/");
	if($keyimg){@unlink("../../upload/pages/img/".$_POST['keyimgold']);	}
	
	$ogimg = SaveUploadImg($_FILES['ogimg'],"../../upload/pages/img/");
	if($ogimg){@unlink("../../upload/pages/img/".$_POST['ogimgold']);	}

	$arrData = array();
	$arrData['SLUG'] = $_POST['slug'];
	$arrData['TITLE'] = $_POST['title'];
	// $arrData['KEYIMG'] = $_POST['keyimg'];
	$arrData['DESC'] = $_POST['desc'];
	$arrData['KEYWORD'] = $_POST['keyword'];
	$arrData['DESCRIPTION'] = $_POST['description'];
	$arrData['DETAIL'] = $_POST['detail'];
	$arrData['OGTITLE'] = $_POST['ogtitle'];
	// $arrData['OGIMG'] = $_POST['ogimg'];
	$arrData['OGSITENAME'] = $_POST['ogsitename'];
	$arrData['OGTYPE'] = $_POST['ogtype'];
	$arrData['OGURL'] = $_POST['ogurl'];
	$arrData['CSS'] = $_POST['css'];
	$arrData['JS'] = $_POST['js'];
	$arrData['DATE'] = date("Y-m-d H:i:s");

	if($keyimg != ""){$arrData['KEYIMG'] = $keyimg;}
	if($ogimg != ""){$arrData['OGIMG'] = $ogimg;}

	$sql = sqlCommandUpdate($tablePageDetail,$arrData," `LAG` = '".$_SESSION['lag']."' AND ID = '".$_GET['id']."' ");
	$query = $conn->query($sql);

}

	$query = "SELECT * FROM `$tablePageDetail` WHERE `LAG` = '".$_SESSION['lag']."' AND ID = '".$_GET['id']."' ORDER BY `ID` ASC ";
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
		$tpl->assign("page",$line['PAGE']);
		$tpl->assign("slug",$line['SLUG']);
		$tpl->assign("title",$line['TITLE']);
		$tpl->assign("desc",$line['DESC']);
		$tpl->assign("keyword",$line['KEYWORD']);
		$tpl->assign("description",$line['DESCRIPTION']);
		$tpl->assign("detail",$line['DETAIL']);
		$tpl->assign("ogtitle",$line['OGTITLE']);
		$tpl->assign("ogsitename",$line['OGSITENAME']);
		$tpl->assign("ogtype",$line['OGTYPE']);
		$tpl->assign("ogurl",$line['OGURL']);
		$tpl->assign("css",$line['CSS']);
		$tpl->assign("js",$line['JS']);

		if(is_file("../../upload/pages/img/".$line['OGIMG'])){
			$tpl->assign("ogimg","<img src='../../upload/pages/img/".$line['OGIMG']."' height='150'>");
			$tpl->assign("ogimgold",$line['OGIMG']);
			$tpl->assign("remove1","<a href='?id=".$line['ID']."&ac=remove1&file1=".$line['OGIMG']."'> Remove image </a>");
		}
		
		if(is_file("../../upload/pages/img/".$line['KEYIMG'])){
			$tpl->assign("keyimg","<img src='../../upload/pages/img/".$line['KEYIMG']."' height='150'>");
			$tpl->assign("keyimgold",$line['KEYIMG']);
			$tpl->assign("remove2","<a href='?id=".$line['ID']."&ac=remove1&file1=".$line['KEYIMG']."'> Remove image </a>");
		}

	}

echo COUNTLANGUAGE($id);

$tpl->printToScreen();

