<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_vdo_gallery.html");
$tpl->prepare();


##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########

if($_SESSION['lagText']=="EN"){

     $page_title =   "VDO Gallery";
     $NewsAndMedia   =   "News and Media";
	$arrayNewsCategory = array('<a href="'.$url_main.'/news" class="nag-button w-button">News</a>',
	'<a href="'.$url_main.'/blog" class="nag-button w-button">Blog</a>',
	'<a href="'.$url_main.'/gallery" class="nag-button w-button">Gallery</a>',	
	'<a href="'.$url_main.'/vdo-gallery" class="nag-button w-button active">VDO Gallery</a>');
}else{
    $page_title =   "วิดีโอแกลลอรี";
    $NewsAndMedia   =   "ข่าวสารและมีเดีย";
	$arrayNewsCategory = array('<a href="'.$url_main.'/ข่าวสารกิจกรรม" class="nag-button w-button">ข่าวสาร</a>',
	'<a href="'.$url_main.'/บทความ" class="nag-button w-button">บทความ</a>',
	'<a href="'.$url_main.'/รูปภาพแกลลอรี" class="nag-button w-button">รูปภาพแกลลอรี</a>',
	'<a href="'.$url_main.'/วิดีโอแกลลอรี" class="nag-button w-button active">วิดีโอแกลลอรี</a>');
}




$slidePath = $url_main."/upload/slideVdo/";


$lag = settype($_SESSION['lag'], "integer");
$query = "SELECT main.*,a.*
  FROM `$tableIndexSlideVdo` as main 
  LEFT JOIN `$tableIndexSlideVdoDetail` as a ON a.ID_SLIDE = main.ID ";
  $query .= " WHERE main.DEL = '0' AND main.STATUS = 'Show' AND a.LAG = '".$lag."' ORDER BY main.ORDER DESC ";
  $result = $conn->query($query);
  while($line = $result->fetch_assoc()){
	  $tpl->newBlock("VDOGallery");


	  $tpl->assign("vdo1080",$slidePath.$line['BANNER_1600']);
	  $tpl->assign("vdo940",$slidePath.$line['BANNER_940']);
	  $tpl->assign("vdo800",$slidePath.$line['BANNER_800']);
	  $tpl->assign("vdo500",$slidePath.$line['BANNER_500']);
//VDO
$lightBox="
<script type=\"application/json\" class=\"w-json\">
        {
            \"items\": [{
                \"url\": \"https://www.youtube.com/watch?v=".$line['URL']."\",
                \"originalUrl\": \"https://www.youtube.com/watch?v=".$line['URL']."\",
                \"width\": 940,
                \"height\": 528,
                \"thumbnailUrl\": \"https://i.ytimg.com/vi/".$line['URL']."/hqdefault.jpg\",
\"html\": \"".str_replace('"','\"',$line['DETAIL'])."\",
                \"type\": \"video\"
            }],
            \"group\": \"VDOGallery\"
        }
    </script>
";
$tpl->assign("Lightbox",$lightBox);
  }







/*
 <script type="application/json" class="w-json">
        {
            "items": [{
                "url": "https://www.youtube.com/watch?v=xJlSbLTSp4U",
                "originalUrl": "https://www.youtube.com/watch?v=xJlSbLTSp4U",
                "width": 940,
                "height": 528,
                "thumbnailUrl": "https://i.ytimg.com/vi/xJlSbLTSp4U/hqdefault.jpg",
                "html": "ฐ",
                "type": "video"
            }],
            "group": ""
        }
    </script>
*/






$tpl->assign("_ROOT.page_title",$page_title);
$tpl->assign("_ROOT.NewsAndMedia",$NewsAndMedia);
$tpl->assign("_ROOT.arrayNewsCategory",implode('', $arrayNewsCategory));
FRONTPAGESEO('18',$_SESSION['lag']);
$tpl->printToScreen();
