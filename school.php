<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");
 


$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_allschool.html");
$tpl->prepare();



$cookietab = isset($_COOKIE['cookietab']) ? $_COOKIE['cookietab'] : 'all';
$tpl->assign("_ROOT.Tab" . ($cookietab == "2567" ? "2567" : ($cookietab == "2566" ? "2566" : "All")), " w--current");


// selected school_camp

//---------------------all

$query = "SELECT * FROM `tb_camp_school_detail` WHERE lag='".$_SESSION['lag']."' ORDER BY id_school ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){




 $campSchool ="<div class='grid-item'>
                <a href='".$url_main."/schools/".$line['slug']."'>
                <img src='".$url_main."/upload/".$line['year']."/brands/".$line['icon']."' alt='".$line['brand_name']."'>
                </a>
                <p>".nl2br(wrapText($line['title'], 30))."</p>
                </div>
             ";

if($line['year']=="2566"){ $arraySchool66 = $arraySchool66.$campSchool;}
if($line['year']=="2567"){ $arraySchool67 = $arraySchool67.$campSchool;}


$campSchool="";
}
$arraySchoolAll = $arraySchool67.$arraySchool66;

$tpl->assign("_ROOT.arraySchool66",$arraySchool66);
$tpl->assign("_ROOT.arraySchool67",$arraySchool67);
$tpl->assign("_ROOT.arraySchoolAll",$arraySchoolAll);




##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########


FRONTPAGESEO('12',$_SESSION['lag']);
$tpl->printToScreen();


