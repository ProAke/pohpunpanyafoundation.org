<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_partners.html");
$tpl->prepare();


/*

$query = "SELECT * FROM `Participants` WHERE year='2567' ORDER BY fname ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("ALN67");
    $tpl->assign("Name",$line['fullname']);
    $tpl->assign("photoALN",$line['photo_aln']);
    }
    
*/


$query = "SELECT * FROM `Participants` WHERE year='2566' ORDER BY fname ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
        $tpl->newBlock("ALN66");
        $tpl->assign("fullname",$line['fullname']);
        $tpl->assign("photoALN",$line['photo_aln']);
        $tpl->assign("profilePOP",$line['profile_pop']);   

}



##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########


FRONTPAGESEO('13',$_SESSION['lag']);
$tpl->printToScreen();
