<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");

$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_school_detail.html");
$tpl->prepare();

$slung = $_GET['id'];
$query = "SELECT * FROM `tb_camp_school` WHERE slung = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $slung);
$stmt->execute();
$result = $stmt->get_result(); 


if ($line = $result->fetch_assoc()) {

    $query2 = "SELECT * FROM `tb_camp_school_detail` WHERE id_school = ? AND lag = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("ss", $line['id'], $_SESSION['lag']);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($line2 = $result2->fetch_assoc()) {
        // ทำงานที่ต้องการหลังจากได้ผลลัพธ์
        
        $tpl->assign("_ROOT.url_main", $url_main);        
        $tpl->assign("_ROOT.year", $line2['year']);
        $tpl->assign("_ROOT.page_title", $line2['title']);
        $tpl->assign("_ROOT.banner", $line2['banner']);   
        $tpl->assign("_ROOT.banner_500", $line2['banner_500']); 
        $tpl->assign("_ROOT.banner_800", $line2['banner_800']);            
        $tpl->assign("_ROOT.banner_1080", $line2['banner_1080']);          
        $tpl->assign("_ROOT.banner_1600", $line2['banner_1600']); 
        $tpl->assign("_ROOT.header", $line2['header']);

        if($line2['text1']){ 
            $tpl->assign("_ROOT.text1", "<p class='school-keytext'>".$line2['text1']."</p>");
        }
        
        if($line2['text2']){  
            $tpl->assign("_ROOT.text2", "<div class='school-headertext' style='color: #837670; '>".$line2['text2']."</div>");
        }
    
    }
    $stmt2->close();

    $query3 = "SELECT * FROM `students` WHERE id_school = ?";
    $stmt3 = $conn->prepare($query3);
    $stmt3->bind_param("s", $line['id']);
    $stmt3->execute();  

    $result3 = $stmt3->get_result();
    while ($line3 = $result3->fetch_assoc()) {
        $tpl->newBlock("STUDENTLIST");
        $tpl->assign("url_main", $url_main);         
        $tpl->assign("name", $line3['name']); 
        $tpl->assign("school_name", $line3['school']); 
        $tpl->assign("year", $line3['year']); 
        $tpl->assign("photo_student", $line3['photo_student']);        
    }

    $query4 = "SELECT * FROM `tb_gallery` WHERE photo_width='full' AND camp_id = ? ORDER BY photo_sort ASC";
    $stmt4 = $conn->prepare($query4);
    $stmt4->bind_param("s", $line['id']);
    $stmt4->execute();
    $result4 = $stmt4->get_result();
    $n=0;
    while ($line4 = $result4->fetch_assoc()) {
    $tpl->newBlock("GALLERY");
    if($n==0){
    $tpl->assign("div_start", "<div class=\"team-slide-wrapper-3 w-slide\">");   
    $tpl->assign("div_items", "<div class=\"team-block-3\">");  
    }else{
        $tpl->assign("div_items", "<div class=\"team-block-3\">");    
    }
         //loop 
         $tpl->assign("url_main", $url_main); 
         $tpl->assign("year", $line4['year']);  
         $tpl->assign("photo", $line4['photo_name']); 
         $tpl->assign("photo_500", $line4['photo_name']); 
         $tpl->assign("photo_800", $line4['photo_name']); 
         $tpl->assign("photo_1064", $line4['photo_name']); 
         

    if($n==0){ 
        $tpl->assign("div_items_end", "</div>");
        $n++;
    }else{
        $tpl->assign("div_items_end", "</div>");
        $tpl->assign("div_end", "</div>"); 
     $n=0;
    }
            

 
    }


}




$stmt->close();



$tpl->assign("_ROOT.logo_brand_alt", $Brand);
##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########
FRONTSCHOOLSEO($pageid,$_SESSION['lag']);


$tpl->printToScreen();

