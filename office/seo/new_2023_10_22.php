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

if($_POST['action']=='save'){

	$keyimg = SaveUploadImg($_FILES['keyimg'],"../../upload/pages/img/");
	if($keyimg){@unlink("../../upload/pages/img/".$_POST['keyimgold']);	}
	
	$ogimg = SaveUploadImg($_FILES['ogimg'],"../../upload/pages/img/");
	if($ogimg){@unlink("../../upload/pages/img/".$_POST['ogimgold']);	}

	$arrData = array();
	$arrData['PAGE'] 	= $_POST['title'];
	$arrData['URL'] = $_POST['ogurl'];
	$query = sqlCommandInsert($tablePage,$arrData);
	$result = $conn->query($query);
	$newId = $conn->insert_id;
	// echo $newId;
////////////////
	if($newId!=''){
		$arrData = array();
		$arrData['ID'] = $newId;
		$arrData['SLUG'] = $_POST['slug'];
		$arrData['TITLE'] = $_POST['title'];
		$arrData['DESC'] = $_POST['desc'];
		$arrData['KEYWORD'] = $_POST['keyword'];
		$arrData['DESCRIPTION'] = $_POST['description'];
		$arrData['DETAIL'] = $_POST['detail'];
		$arrData['OGTITLE'] = $_POST['ogtitle'];
		$arrData['OGSITENAME'] = $_POST['ogsitename'];
		$arrData['OGTYPE'] = $_POST['ogtype'];
		$arrData['OGURL'] = $_POST['ogurl'];
		$arrData['CSS'] = $_POST['css'];
		$arrData['JS'] = $_POST['js'];
		$arrData['DATE'] = date("Y-m-d H:i:s");

		if($keyimg != ""){$arrData['KEYIMG'] = $keyimg;}
		if($ogimg != ""){$arrData['OGIMG'] = $ogimg;}

		for ($i=1; $i <= COUNTLANGUAGE('') ; $i++) {
			$arrData['LAG'] = $i; 
			$sql = sqlCommandInsert($tablePageDetail,$arrData);
			$query = $conn->query($sql);
		}
	}else{

	}



}


	$tpl->newBlock("DATA");


$tpl->printToScreen();

