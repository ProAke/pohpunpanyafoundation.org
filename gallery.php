<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");

$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_gallery.html");
$tpl->prepare();


##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########

if($_SESSION['lagText']=="EN"){
	$arrayNewsCategory = array('<a href="'.$url_main.'/news" class="nag-button w-button">News</a>',
	'<a href="'.$url_main.'/blog" class="nag-button w-button">Blog</a>',
	'<a href="'.$url_main.'/gallery" class="nag-button w-button active">Gallery</a>',	
	'<a href="'.$url_main.'/vdo-gallery" class="nag-button w-button">VDO Gallery</a>');
}else{
	$arrayNewsCategory = array('<a href="'.$url_main.'/ข่าวสารกิจกรรม" class="nag-button w-button">ข่าวสาร</a>',
	'<a href="'.$url_main.'/บทความ" class="nag-button w-button">บทความ</a>',
	'<a href="'.$url_main.'/แกลเลอรี" class="nag-button w-button active">แกลเลอรี</a>',
	'<a href="'.$url_main.'/วิดีโอแกลเลอรี" class="nag-button w-button">วิดีโอแกลเลอรี</a>');
}
$tpl->assign("_ROOT.arrayNewsCategory",implode('', $arrayNewsCategory));


$query = "SELECT * FROM tb_camp_school ORDER BY id DESC";    
$result = $conn->query($query);


while($line = $result->fetch_assoc()){
$query2 = "SELECT * FROM tb_gallery WHERE `camp_id`='".$line['id']."' AND   `photo_width`='full' ORDER BY `photo_sort` ASC";       
$result2 = $conn->query($query2);

while($line2 = $result2->fetch_assoc()){
$tpl->newBlock("GALLERY");
$tpl->assign("camp_name",$line['title']);
$tpl->assign("camp_id","camp_".$line['id']);	
$photo = "images/".$line2['year']."/gallery/".$line2['photo_name'];

	$tpl->assign("photo_name",$line2['photo_name']);	
    $tpl->assign("photo",$photo);	
	$tpl->assign("photo1064",$photo);
	$tpl->assign("photo800",$photo);
	$tpl->assign("photo500",$photo);	
}


}



FRONTPAGESEO('17',$_SESSION['lag']);
$tpl->printToScreen();
