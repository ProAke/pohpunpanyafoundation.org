<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");


$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_partners.html");
$tpl->prepare();


$tg = isset($_GET['tg']) ? $_GET['tg'] : '';
$tpl->assign("_ROOT.curel",$url_main."/partners");
$tpl->assign("_ROOT.main_url",$url_main);
$tpl->assign("_ROOT.img_url",$img_path);



$query = "SELECT * FROM `tb_campYear` ORDER BY id DESC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){

    $campYear = $line['year'];
    $campNameYear = $line['name'];

    $tpl->newBlock("TABYEAR");
    $tpl->assign("tabID",$line['id']);
    $tpl->assign("campNameYear",$campNameYear);

    $tpl->newBlock("TAB");
    $tpl->assign("tabID",$line['id']);
    $tpl->assign("campYear",$campYear);


    $query2 = "SELECT * FROM `tb_camp_detail` WHERE `YEAR` ='".$campYear."' AND `LAG` ='".$_SESSION['lag']."' ORDER BY id ASC";
    $result2 = $conn->query($query2);
    while($line2 = $result2->fetch_assoc()){
        $tpl->newBlock($line2['ROLE']);
        $tpl->assign("campHead",$line2['HEAD_CAMP']);
        $tpl->assign("campSubHead",$line2['SUB_CAMP']);
        $ids = json_decode($line2['TEACHER'], true);



//--------------------------------------

$sn=0;
$id_list = implode(",", $ids);
$query4 = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result4 = $conn->query($query4);
while($line4 = $result4->fetch_assoc()){
    $sn++;
    if($line2['ROLE']=="SPEAKER"){$tpl->newBlock("TEACHER");}
    if($line2['ROLE']=="COMMITTEE"){$tpl->newBlock("TEACHER2");}
    $sn++;
    $role="";
    if($line4['role']=="วิทยากร"){$role="lecturer";}
    if($line4['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line4['fullname']);
    $tpl->assign("Subtext",$line4['subtext']);
   
    $profileUrl = "./upload/".$line4['year']."/teachers/popup/".$line4['profile_pop'];
    $group = $line4['role']."-".$line4['year'];
    $newId = "101010101";
    $profile_pop = $line4['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line4['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line4['role']."-".$line4['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line4['profile_pop'],
                "fileName" => $line4['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line4['fullname'],
                "type" => "image"
            ]
        ],
        "group" => $group
    ]);

    // ดำเนินการแทรก JSON ลงในบล็อก profile_pop
    $Jprofile_pop= '<script type="application/json" class="w-json">' . $jsonDataImage . '</script>';

    }
}
if (!empty($url_yt)) {
    $youtubeId = $url_yt;
    $urlLink ="https://www.youtube.com/watch?v=".$youtubeId;


    $jsonDataVideo = '
    {
        "items": [{
            "url": "https://www.youtube.com/watch?v='.$youtubeId.'",
            "originalUrl": "https://www.youtube.com/watch?v='.$youtubeId.'",
            "width": 940,
            "height": 528,
            "thumbnailUrl": "https://i.ytimg.com/vi/'.$youtubeId.'/hqdefault.jpg",
            "html": "<iframe width=\"940\" height=\"528\" src=\"https://www.youtube.com/embed/'.$youtubeId.'?si=uuJN54mS7INMWCyO&rel=0\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>",
            "type": "video"
        }],
        "group": "'.$line4['fullname'].'"
    }

 ';







    $Jurl_yt = '<script type="application/json" class="w-json">' . $jsonDataVideo . '</script>';



}

$iconPack = '<ul role="list" class="list w-list-unstyled">';
if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $iconPack .= '<li class="list-item-1">
                    <a href="#" class="partnerlightbox w-inline-block w-lightbox">
                        <img src="images/icon-coa-folder.png" loading="lazy" width="30" alt="">
                        ' . $Jprofile_pop . '
                    </a>
                  </li>';
    }else{
        $iconPack .= '<li class="list-item-1">
        
            <img src="images/icon-coa-folder.png" loading="lazy" width="30" alt="ยังไม่มี profile" style="opacity: 0.5;">
        
      </li>';

    }
}
if (!empty($url_yt)) {
    $iconPack .= '<li class="list-item-2">
                    <a href="#" class="partnerlightbox w-inline-block w-lightbox">
                        <img src="images/icon-coa-vdo.png" loading="lazy" width="30" alt="">
                        ' . $Jurl_yt . '
                    </a>
                  </li>';
}
$iconPack .= '</ul>';
    
    $tpl->assign("iconPack", $iconPack);
    $tpl->assign("photo",$url_main."/upload/".$line4['year']."/teachers/".$role."/".$line4['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line4['year']."/teachers/profile/".$line4['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
        //----------------------
        
    }




}


//--------------------------------------- all
$query = "SELECT * FROM `tb_logo_brand` ORDER BY sort ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("LOGOBRANDS");
    $tpl->assign("main_url",$url_main);
    $tpl->assign("brandImg",$line['logo_image']);
}


##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########


FRONTPAGESEO('13',$_SESSION['lag']);
$tpl->printToScreen();
