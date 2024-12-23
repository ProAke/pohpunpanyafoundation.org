<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");

$tpl = new TemplatePower("./template/_tp_master.html");

if($_GET['id']=='chiang' || $_GET['id']=='chiangklang-prachapattana-school-numprik-samza'){


$query = "SELECT * FROM `detail` WHERE id";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){

$tpl->assignInclude("body", "template/_tp_nw_detail.html");
$tpl->prepare();
$tpl->assign("_ROOT.page_title", $line['page_title']);
$tpl->assign("_ROOT.nw_name", $line['nw_group']);
$tpl->assign("_ROOT.logo_brand_alt", $Brand);
$tpl->assign("_ROOT.nw_keyimg", $Brand);



}



if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
FRONTPAGESEO('4',$_SESSION['lag']);
$tpl->printToScreen();
?>