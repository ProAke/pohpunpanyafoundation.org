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





// LOOP PICKER
/*
for($i = 0; $i < 3; $i++) {
    $tpl->newBlock("PICKER");
    $tpl->assign("headCamp", "Camp : " . $i);
    $tpl->assign("subCamp", "กิจกรรมแคมป์ รุ่นปี " . (2566 + $i));
}
*/






//1 NEP67
//--------------------------------------
$ids = [19,20];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("NEP67");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------


//2. Test
//--------------------------------------
$ids = [21,22,23,24];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("NBC67");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------



//3. Test
//--------------------------------------
$ids = [25,26];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("CCC67");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------

// 4.Dare to Step Camp  (DSC67)
//--------------------------------------
$ids = [27];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("DSC67");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------






//. Gray Start >>> Dare to Learn Camp
//--------------------------------------
$ids = [28, 29, 30, 31, 32];

$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("DLCP67");

    if($sn ==0){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $sn++;    
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------






//--------------------------------------
$ids = [33, 34, 35, 36];
$id_list = implode(",", $ids);
$sn=0;
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("DECP67");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']); 
 
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;}
    if($line['id'] ==36){    $tpl->assign("end_flex", '</div>');}
}
//--------------------------------------






//DECP2
//--------------------------------------
$ids = [37, 38, 39, 40];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("DECP267");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------



//-----------------------------------2566
//1.กล้าเรียน
//--------------------------------------
$ids = [1,2,3,4];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("NBC66");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------
//2.กล้าลุย
//--------------------------------------
$ids = [11,12];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("GPC66");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------
//4.กล้าก้าว
//--------------------------------------
$ids = [5,6,7,8];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("LCC66");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------
//3.กล้าก้าว
//--------------------------------------
$ids = [13];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("GOC66");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------
//5.กล้าก้าว
//--------------------------------------
$ids = [9,10];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("LCC266");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------
//6.กล้าก้าว
//--------------------------------------
$ids = [14,15,16,17];
$sn=0;
$id_list = implode(",", $ids);
$query = "SELECT * FROM `Participants` WHERE id IN ($id_list) GROUP BY fullname ORDER BY id ASC";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
    $tpl->newBlock("GOGO66");
    $sn++;
    if($sn ==1){    $tpl->assign("start_flex", '<div class="w-layout-hflex partnerblock">');}
    $role="";
    if($line['role']=="วิทยากร"){$role="lecturer";}
    if($line['role']=="กรรมการ"){$role="committee";}
    $tpl->assign("FullName",$line['fullname']);
    $tpl->assign("Subtext",$line['subtext']);
   
    $profileUrl = "./upload/".$line['year']."/teachers/popup/".$line['profile_pop'];
    $group = $line['role']."-".$line['year'];
    $newId = "101010101";
    $profile_pop = $line['profile_pop'];  // ข้อมูลสำหรับ profile_pop
    $url_yt = $line['url_yt'];  // ข้อมูลสำหรับ URL ของ YouTube






if (!empty($profile_pop)) {
    if (file_exists($profileUrl)) {
    $group = $line['role']."-".$line['year'];
    $jsonDataImage = json_encode([
        "items" => [
            [
                "_id" => $newId, 
                "origFileName" => $line['profile_pop'],
                "fileName" => $line['profile_pop'],
                "fileSize" => 222311,
                "height" => 1202,
                "url" => $profileUrl,
                "width" => 800,
                "caption" => $line['fullname'],
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
        "group": "'.$line['fullname'].'"
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
    $tpl->assign("photo",$url_main."/upload/".$line['year']."/teachers/".$role."/".$line['photo']);
    $tpl->assign("profilePOP",$url_main."/upload/".$line['year']."/teachers/profile/".$line['profile_pop']);
    if($sn ==4){    $tpl->assign("end_flex", '</div>');$sn=0;} 
}
//--------------------------------------





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
