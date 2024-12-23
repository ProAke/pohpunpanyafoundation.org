<?php
error_reporting(E_ALL ^ E_NOTICE);

include_once("include/config.inc.php");
include_once("include/class.inc.php");
include_once("include/class.TemplatePower.inc.php");
include_once("include/function.inc.php");

$tpl = new TemplatePower("template/_tp_master.html");
$tpl->assignInclude("body", "template/_tp_index_mock.html");
$tpl->prepare();


if (isset($_POST['language'])) {
    $_SESSION['lag'] = $_POST['language'];
} elseif (!isset($_SESSION['lag'])) {
    $_SESSION['lag'] = '1';
}

FRONTLANGUAGE($_SESSION['lag']);



$arrayCampProvince = array();
$query = "SELECT main.*,a.*
    FROM `$tableCampProvince` as main 
    LEFT JOIN `$tableCampProvinceDetail` as a ON a.ID_PROVINCE = main.ID
    WHERE main.STATUS = 'Show' AND main.ID_MODEL = '1' AND a.LAG = ? 
    ORDER BY main.ORDER ASC";

// Use prepared statements
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $_SESSION['lag']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($line = $result->fetch_assoc()) {
        array_push($arrayCampProvince, '<a href="#" id="province' . $line['ID_PROVINCE'] . '" data-title="' . $line['TITLE'] . '" class="drp_province_list top w-dropdown-link" onclick="chooseCity(' . $line['ID_PROVINCE'] . ')" >' . $line['TITLE'] . '</a>');

        $query2 = "SELECT main.*,a.*
            FROM `$tableCampDistrict` as main 
            LEFT JOIN `$tableCampDistrictDetail` as a ON a.ID_DISTRICT = main.ID
            WHERE main.ID_MODEL = '1' AND main.ID_PROVINCE = ? AND a.LAG = ? AND  main.STATUS = 'Show' ORDER BY main.ORDER ASC";

        // Use another prepared statement
        $stmt2 = $conn->prepare($query2);

        if ($stmt2) {
            $stmt2->bind_param("ss", $line['ID'], $_SESSION['lag']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            while ($line2 = $result2->fetch_assoc()) {
                $query3 = "SELECT * FROM `$tableCampSchool` WHERE `STATUS` = 'Show' AND `ID_MODEL` = '1' AND `ID_PROVINCE` = ? AND `ID_DISTRICT` = ?";
                
                // Another prepared statement
                $stmt3 = $conn->prepare($query3);

                if ($stmt3) {
                    $stmt3->bind_param("ss", $line['ID_PROVINCE'], $line2['ID_DISTRICT']);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();

                    if ($result3->num_rows > 1) {
                        array_push($arrayCampProvince, '<a href="#" id="district' . $line2['ID_DISTRICT'] . '" data-title="' . $line2['TITLE'] . '" class="drp_province_list  w-dropdown-link" onclick="chooseDistrict(' . $line2['ID_DISTRICT'] . ')" >' . $line2['TITLE'] . '<span style="float: right;">' . $result3->num_rows . ' โรงเรียน</span></a>');
                    } else {
                        array_push($arrayCampProvince, '<a href="#" id="district' . $line2['ID_DISTRICT'] . '" data-title="' . $line2['TITLE'] . '" class="drp_province_list  w-dropdown-link" onclick="chooseDistrict(' . $line2['ID_DISTRICT'] . ')" >' . $line2['TITLE'] . '<span style="float: right;">' . $result3->num_rows . ' โรงเรียน </span></a>');
                    }
                }

                $stmt3->close();
            }

            $stmt2->close();
        }
    }

    $stmt->close();
}

$tpl->assign("_ROOT.arrayCampProvince", implode('', $arrayCampProvince));

/////////////////////////////////////////////////
$arrayCampSchool = array();
$arrayCampSchoolDetail = array();
$query = "SELECT main.*, a.*
FROM `$tableCampSchool` as main 
LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
$query .= " WHERE main.STATUS = 'Show' AND main.ID_MODEL = '1' AND a.LAG = ? ORDER BY main.ORDER ASC ";

$stmt = $conn->prepare($query);
$stmt->bind_param('s', $_SESSION['lag']);
$stmt->execute();
$result = $stmt->get_result();

while ($line = $result->fetch_assoc()) {
    $ex = explode('=', $line['LINK']);
    array_push($arrayCampSchool, '<a href="' . $url_main . '/schools/' . $ex[1] . '" class="drp_school_list w-dropdown-link" onmouseover="viewSchool(' . $line['ID_SCHOOL'] . ');" onmouseout="closeViewSchhol();" style="display: block;">' . $line['TITLE'] . '</a>');
}

$tpl->assign("_ROOT.arrayCampSchool", implode('', $arrayCampSchool));
$stmt->close();
/////////////////////////////////////////////////

$arrayCampMapMobile = array();
$arrayCampMapTablet = array();
$arrayCampMapPc = array();
$noCampSchool = '0';
$query = "SELECT * FROM `$tableCampSchool` as main 
LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
$query .= " WHERE main.STATUS = 'Show' AND a.LAG = ? ORDER BY main.ORDER ASC ";

$stmt = $conn->prepare($query);
$stmt->bind_param('s', $_SESSION['lag']);
$stmt->execute();
$result = $stmt->get_result();

while ($line = $result->fetch_assoc()) {
    $noCampSchool++;
    array_push($arrayCampMapMobile, '#tree' . $noCampSchool . ' {top: 0;left: 0;margin: ' . $line['MAP_MOBILE'] . ';}');
    array_push($arrayCampMapTablet, '#tree' . $noCampSchool . ' {top: 0;left: 0;margin: ' . $line['MAP_TABLET'] . ';}');
    array_push($arrayCampMapPc, '#tree' . $noCampSchool . ' {top: 0;left: 0;margin: ' . $line['MAP_PC'] . ';}');
}

$tpl->assign("_ROOT.arrayCampMapMobile", implode('', $arrayCampMapMobile));
$tpl->assign("_ROOT.arrayCampMapTablet", implode('', $arrayCampMapTablet));
$tpl->assign("_ROOT.arrayCampMapPc", implode('', $arrayCampMapPc));

$stmt->close();






FRONTPAGESEO('1',$_SESSION['lag']);
$tpl->printToScreen();
?>