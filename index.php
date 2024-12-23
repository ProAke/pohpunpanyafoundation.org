<?php
error_reporting(E_ALL ^ E_NOTICE);

include_once("include/config.inc.php");
include_once("include/class.inc.php");
include_once("include/class.TemplatePower.inc.php");
include_once("include/function.inc.php");

$tpl = new TemplatePower("template/_tp_master.html");
$tpl->assignInclude("body", "template/_tp_index.html");
$tpl->prepare();


$tpl->assign("_ROOT.main_url", $url_main);


// Set language session variable
if (isset($_POST['language'])) {
    $_SESSION['lag'] = $_POST['language'];
} elseif (!isset($_SESSION['lag'])) {
    $_SESSION['lag'] = '1';
}

FRONTLANGUAGE($_SESSION['lag']);



/////////////////////////////////////////////////
$arraySlide = array();
$noSlide = '0';
$query = "SELECT main.*, a.*
          FROM `$tableIndexSlide` as main 
          LEFT JOIN `$tableIndexSlideDetail` as a ON a.ID_SLIDE = main.ID 
          WHERE main.DEL = '0' AND main.STATUS = 'Show' AND a.LAG = ? ORDER BY main.ORDER DESC ";

$stmt = $conn->prepare($query);
$stmt->bind_param('s', $_SESSION['lag']);
$stmt->execute();
$result = $stmt->get_result();

while ($line = $result->fetch_assoc()) {
    $noSlide++;
    array_push($arraySlide, '<div class="slide w-slide">
<a href="' . $line['URL'] . '" class="sliderlink w-inline-block">
<img src="' . $url_main . '/upload/slide/' . $line['BANNER_NAME'] . '" width="100%" height="100%" alt="' . $line['TITLE'] . '" class="slide_visual slide' . $noSlide . '"></a>
        <link rel="prerender" href="' . $line['URL'] . '">
      </div>');
}

$stmt->close();
$tpl->assign("_ROOT.arraySlide", implode('', $arraySlide));



	$arraySlideVdo = array();
	$SlideVdo = '0';
  $lag = settype($_SESSION['lag'], "integer");
  $query = "SELECT main.*,a.*
	FROM `$tableIndexSlideVdo` as main 
	LEFT JOIN `$tableIndexSlideVdoDetail` as a ON a.ID_SLIDE = main.ID ";
	$query .= " WHERE main.DEL = '0' AND main.STATUS = 'Show' AND a.LAG = '".$lag."' ORDER BY main.ORDER DESC ";
	$result = $conn->query($query);
	while($line = $result->fetch_assoc()){
		$SlideVdo++;
    
		array_push($arraySlideVdo, '<div class="pppy_slide1 w-slide">
            <a href="#" class="w-inline-block w-lightbox">
			<img src="'.$url_main.'/upload/slideVdo/'.$line['BANNER_NAME'].'" width="100%" height="100%" 
			sizes="(max-width: 479px) 100vw,
			(max-width: 767px) 96vw,
			(max-width: 991px) 92vw,
			(max-width: 1439px) 94vw,
			940px" srcset="'.$url_main.'/upload/slideVdo/'.$line['BANNER_500'].' 500w,
			'.$url_main.'/upload/slideVdo/'.$line['BANNER_800'].
				   ' 800w, '.$url_main.'/upload/slideVdo/'.$line['BANNER_940'].
				   '" alt="">
              <script type="application/json" class="w-json">{
  "items": [
    {
      "url": "https://www.youtube.com/watch?v='.$line['URL'].'",
      "originalUrl": "https://www.youtube.com/watch?v='.$line['URL'].'",
      "width": 940,
      "height": 528,
      "thumbnailUrl": "https://i.ytimg.com/vi/'.$line['URL'].'/hqdefault.jpg",
      "html": "'.str_replace('"','\"',$line['DETAIL']).'",
      "type": "video"
    }
  ],
  "group": ""
}</script>
            </a>
          </div>');
	}

$tpl->assign("_ROOT.arraySlideVdo",implode('', $arraySlideVdo));






//--------------------------------------- all

$query = "SELECT * FROM `tb_logo_brand` ORDER BY sort ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("LOGOBRANDS");
    $tpl->assign("brandImg",$line['logo_image']);
}





$query = "SELECT * FROM `Participants` 
            WHERE role = 'กรรมการ' AND fname !='กัลย์ชฎารัตน์'
            AND fname !='วรกันต์'
            AND fname !='อารีย์'
            GROUP BY fullname 
            ORDER BY convert(fname using tis620) ASC 
            LIMIT 5";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("ALN67");
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("photoALN",$url_main."/upload/".$line['year']."/teachers/alumni/".$line['photo_aln']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);  
    $url_img = $url_main."/upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $popJS ='
    {
                                    "items": [{
                                        "_id": "651a3040342015fefc8ab435",
                                        "origFileName": "'.$line['photo_name'].'",
                                        "fileName": "'.$line['photo_name'].'",
                                        "fileSize": 270941,
                                        "height": 1600,
                                        "url": "'.$url_img.'",
                                        "width": 800,
                                        "caption": "'.$line['fullname'].'",
                                        "type": "image"
                                         }],
                                        "group": "วิทยากร-all"
                                }
    ';
$tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/popup/".$line['profile_pop']);  
$tpl->assign("popJS",$popJS);

    
    }
    



$query = "SELECT * FROM `Participants` 
            WHERE role = 'วิทยากร' 
            GROUP BY fullname 
            ORDER BY convert(fname using tis620) ASC 
            LIMIT 5";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){ 
        $tpl->newBlock("ALN66");
        $tpl->assign("Year",$line['year']);
        $tpl->assign("FullName",$line['fullname']);
        $tpl->assign("photoALN",$url_main."/upload/".$line['year']."/teachers/alumni/".$line['photo_aln']);
        $tpl->assign("profilePOP",$line['profile_pop']);   


        $url_img = $url_main."/upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
        $popJS ='
        {
                                        "items": [{
                                            "_id": "651a3040342015fefc8ab435",
                                            "origFileName": "'.$line['profile_pop'].'",
                                            "fileName": "'.$line['profile_pop'].'",
                                            "fileSize": 270941,
                                            "height": 1600,
                                            "url": "'.$url_img.'",
                                            "width": 800,
                                            "caption": "'.$line['fullname'].'",
                                            "type": "image"
                                             }],
                                            "group": "กรรมการ-all"
                                    }
        ';
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/popup/".$line['profile_pop']);  
    $tpl->assign("popJS",$popJS);
    






}


//----------------




if($_SESSION['lagText']=="EN"){
	$arrayNewsCategory = array('<a href="'.$url_main.'/news" class="nag-button w-button">News</a>',
  '<a href="'.$url_main.'/blog" class="nag-button w-button">Blog</a>',
  '<a href="'.$url_main.'/gallery" class="nag-button w-button">Gallery</a>',
  '<a href="'.$url_main.'/vdogallery" class="nag-button w-button">VDO Gallery</a>');
}else{
	$arrayNewsCategory = array('<a href="'.$url_main.'/ข่าวสาร" class="nag-button w-button">ข่าวสาร</a>','<a href="'.$url_main.'/บทความ" class="nag-button w-button">บทความ</a>',
  '<a href="'.$url_main.'/รูปภาพแกลลอรี" class="nag-button w-button">รูปภาพแกลลอรี</a>',
  '<a href="'.$url_main.'/วีดีโอแกลลอรี" class="nag-button w-button">วิดีโอแกลลอรี</a>');
}

$tpl->assign("_ROOT.arrayNewsCategory",implode('', $arrayNewsCategory));

$query = "SELECT main.*,a.TITLE_".$_SESSION['lagText']." as TITLECAT
FROM `$tableNews` as main 
LEFT JOIN `$tableNewsCategory` as a ON a.ID = main.ID_NEWS_CAT";
$query .= " ORDER BY main.DAY DESC, main.ID DESC LIMIT 0,6 ";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
	// $no++;
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


##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);


FRONTPAGESEO('1',$_SESSION['lag']);
$tpl->printToScreen();
?>