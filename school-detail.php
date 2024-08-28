<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");

// echo $_SERVER['DOCUMENT_ROOT']."/template/_tp_master.html";

// $tpl = new TemplatePower("".$_SERVER['DOCUMENT_ROOT']."/template/_tp_master.html");

$tpl = new TemplatePower("./template/_tp_master.html");

if($_GET['id']=='chiang' || $_GET['id']=='chiangklang-prachapattana-school-numprik-samza'){
	$tpl->assignInclude("body", "./template/_tp_chiang-klang-pracha-pattana.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนเชียงกลาง ประชาพัฒนา น่าน");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=1;
}elseif($_GET['id']=='pratatpittayakom' || $_GET['id']=='pratatpittayakhom-school-mongdee-phee'){
	$tpl->assignInclude("body", "./template/_tp_pratatpittayakom.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนพระธาตุพิทยาคม");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=2;

}elseif($_GET['id']=='pitthayakhom' || $_GET['id']=='thawangphapittayakhom-school-kado'){
	$tpl->assignInclude("body", "./template/_tp_tha-wang-pha-pitthayakhom.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนท่าวังผาพิทยาคม");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=3;
}elseif($_GET['id']=='puaschool' || $_GET['id']=='pao-school-mamuen-butter'){
	$tpl->assignInclude("body", "./template/_tp_pua-school.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนปัว");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=4;
}elseif($_GET['id']=='srisawatwittayakarn' || $_GET['id']=='srisawatwittayakarn-school-lanala'){
	$tpl->assignInclude("body", "./template/_tp_Srisawatwittayakarn-School.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนศรีสวัสดิ์วิทยาคาร");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=5;
}elseif($_GET['id']=='saschool' || $_GET['id']=='sa-school-laam-ruay'){
	$tpl->assignInclude("body", "./template/_tp_sa-school.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนสา");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=6;
}elseif($_GET['id']=='orngeriiyn' || $_GET['id']=='rajaprajanugroh56-school-cookie-ten-bites'){
	$tpl->assignInclude("body", "./template/_tp_orngeriiyn-raachprachaanuekhraaah-56-cchanghwadnaan.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนราชประชานุเคราะห์ 56 จังหวัดน่าน");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=7;
}elseif($_GET['id']=='orngeriiynemuue' || $_GET['id']=='munglee-school-lina'){
	$tpl->assignInclude("body", "./template/_tp_muanglee-school.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนเมืองลีประชาสามัคคี");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=8;


	# Year 67
}elseif($_GET['id']=='nplant' || $_GET['id']=='mueang-nplant'){
	$tpl->assignInclude("body", "./template/_tp_67mueang-nplant.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ทีมอำเภอเมือง รร.น่านคริสเตียน, รร.สตรีศรีน่าน");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=9;

}elseif($_GET['id']=='spakaitee' || $_GET['id']=='thawungpa-spakaitee'){
	$tpl->assignInclude("body", "./template/_tp_67thawungpa_spakaitee.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ทีมอำเภอท่าวังผา รร.เมืองยมวิทยาคาร, รร. หนองบัวพิทยาคม");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=10;

}elseif($_GET['id']=='puengpiknan' || $_GET['id']=='weangsa-puengpiknan'){
	$tpl->assignInclude("body", "./template/_tp_67weangsa_puengpiknan.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ทีมอำเภอเวียงสา รร.สาธุกิจประชาสรรค์ รัชมังคลาภิเษก,รร. สารทิศพิทยาคม");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=11;

}elseif($_GET['id']=='sanstyle' || $_GET['id']=='bokluea-sanstyle'){
	$tpl->assignInclude("body", "./template/_tp_67bokluea_sanstyle.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ทีมอำเภอบ่อเกลือ รร.บ่อเกลือ");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=12;

}elseif($_GET['id']=='freshhearb' || $_GET['id']=='phuphiang-freshhearb'){
	$tpl->assignInclude("body", "./template/_tp_67phuphiang_freshhearb.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ทีมอำเภอภูเพียง รร.ศรีนครน่าน");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=13;

}elseif($_GET['id']=='krafturai' || $_GET['id']=='songkwae-krafturai'){
	$tpl->assignInclude("body", "./template/_tp_67songkwae_krafturai.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ทีมอำเภอสองแคว รร.ไตรเขตประชาสามัคคี รัชมัคลาภิเษก");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=14;
}elseif($_GET['id']=='thamtham' || $_GET['id']=='nanoi-thamtham'){
	$tpl->assignInclude("body", "./template/_tp_67nanoi_thamtham.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ทีมอำเภอนาน้อย รร.นาน้อย");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=15;

}elseif($_GET['id']=='sillfeed' || $_GET['id']=='namuen-sillfeed'){
	$tpl->assignInclude("body", "./template/_tp_67namuen_sillfeed.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ทีมอำเภอนาหมื่น รร.นาหมื่นพิทยาคม");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=16;
}elseif($_GET['id']=='korkwan' || $_GET['id']=='pua-korkwan'){
	$tpl->assignInclude("body", "./template/_tp_67pua_korkwan.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ทีมอำเภอปัว รร.มัธยมป่ากลาง");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=17;
}elseif($_GET['id']=='instan' || $_GET['id']=='maecharim-instan'){
	$tpl->assignInclude("body", "./template/_tp_67maecharim_instan.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "ทีมอำเภอแม่จริม รร.แม่จริม");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=18;

}


















##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########
FRONTSCHOOLSEO($pageid,$_SESSION['lag']);


$tpl->printToScreen();

