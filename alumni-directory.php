<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_alumni-directory.html");
$tpl->prepare();


$query = "SELECT * FROM `students` ORDER BY fname ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("ALN67");
    $tpl->assign("Name",$line['name']);
    $tpl->assign("photoALN",$line['photo_aln']);
    }
    






/*
// เตรียมคำสั่ง SQL โดยใช้การเตรียม statement
$query = "SELECT * FROM `students` WHERE year = ? ORDER BY fname ASC";

// year 67 
$stmt67 = $conn->prepare($query);
if (!$stmt67) {
    die("Error preparing statement: " . $conn->error);
}
$year67 = '2567';
$stmt67->bind_param('s', $year67); 
$stmt67->execute();
$result67 = $stmt67->get_result();
while ($line67 = $result->fetch_assoc()) {
    $tpl->newBlock("ALN67");
    $tpl->assign("Name", $line67['name']);
    $tpl->assign("photoALN", $line67['photo_aln']);
}
$stmt67->close();
// year66
$stmt66 = $conn->prepare($query);
if (!$stmt66) {
    die("Error preparing statement: " . $conn->error);
}
$year67 = '2566';
$stmt66->bind_param('s', $year66); 
$stmt66->execute();
$result67 = $stmt67->get_result();
while ($line66 = $result->fetch_assoc()) {
    $tpl->newBlock("ALN66");
    $tpl->assign("Name", $line66['name']);
    $tpl->assign("photoALN", $line66['photo_aln']);
}
$stmt66->close();

*/
##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########



FRONTPAGESEO('14',$_SESSION['lag']);
$tpl->printToScreen();