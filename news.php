<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_news.html");
$tpl->prepare();


##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########




// $arrayNewsCategory = array();
// $query = "SELECT * FROM `$tableNewsCategory` ORDER BY `ORDER` ASC ";
// $result = $conn->query($query);

// while($line = $result->fetch_assoc()){
    
//     if($line['ID']==1){$active=" active";}
// 	array_push($arrayNewsCategory, '<a href="'.$line['URL'].'" class="nag-button w-button'.$active.'" >'.$line['TITLE_'.$_SESSION['lagText']].'</a>');
//     $active="";
// }



if($_SESSION['lagText']=="EN"){
	$arrayNewsCategory = array('<a href="'.$url_main.'/news" class="nag-button w-button active">News</a>',
	'<a href="'.$url_main.'/blog" class="nag-button w-button">Blog</a>',
	'<a href="'.$url_main.'/gallery" class="nag-button w-button">Gallery</a>',	
	'<a href="'.$url_main.'/vdo-gallery" class="nag-button w-button">VDO Gallery</a>');
}else{
	$arrayNewsCategory = array('<a href="'.$url_main.'/ข่าวสารกิจกรรม" class="nag-button w-button active">ข่าวสาร</a>',
	'<a href="'.$url_main.'/บทความ" class="nag-button w-button">บทความ</a>',
	'<a href="'.$url_main.'/แกลเลอรี" class="nag-button w-button">แกลเลอรี</a>',
	'<a href="'.$url_main.'/วิดีโอแกลเลอรี" class="nag-button w-button">วิดีโอแกลเลอรี</a>');
}



$tpl->assign("_ROOT.arrayNewsCategory",implode('', $arrayNewsCategory));

$no='0';
$query = "SELECT main.*,a.TITLE_".$_SESSION['lagText']." as TITLECAT
FROM `$tableNews` as main 
LEFT JOIN `$tableNewsCategory` as a ON a.ID = main.ID_NEWS_CAT";
$query .= " ORDER BY main.DAY DESC, main.ID DESC LIMIT 0,6 ";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
	$no++;
    if($line['ID_NEWS_CAT']=="1"){
	
            $tpl->newBlock("LISTNEWS");
	        $tpl->assign("titlecat",$line['TITLECAT']);
	        $tpl->assign("title",nl2br($line['TITLE_'.$_SESSION['lagText']]));
	        $tpl->assign("desc",nl2br($line['DESC_'.$_SESSION['lagText']]));
	        $tpl->assign("img",$url_main.'/upload/news/'.$line['FULLIMG']);
	        $tpl->assign("id",$line['SLUG']);

	        if($_SESSION['lag']=='2'){
		    $tpl->assign("date",EngDateLong($line['DAY'],'false'));
				

	}else{
		$tpl->assign("date",ThaiDateShort($line['DAY'],'false'));
	}


    }
	

	
	
}










FRONTPAGESEO('4',$_SESSION['lag']);
$tpl->printToScreen();
