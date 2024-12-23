<?php
include_once("./include/config.inc.php");

$data = json_decode(file_get_contents('php://input'), true);
$letter = $data['letter'];
$role = $data['role'];

// เงื่อนไขพิเศษสำหรับ "กรรมการ"
$kill = "";
if ($role == "กรรมการ") {
    $kill = "AND fname != 'กัลย์ชฎารัตน์' AND fname != 'วรกันต์' AND fname != 'อารีย์'";
}

if (($letter != "") && $role != "") {
    // กรองข้อมูลตามตัวอักษร
    $query = "SELECT * FROM `Participants` 
              WHERE role = '$role'
              $kill
              AND fname LIKE '$letter%'
              GROUP BY fullname
              ORDER BY convert(fname using tis620) ASC";
} else {
    // โหลดข้อมูลทั้งหมด
    $query = "SELECT * FROM `Participants` 
              WHERE role = '$role'
              $kill
              GROUP BY fullname
              ORDER BY convert(fname using tis620) ASC";
}

$result = $conn->query($query);
$participants = array();

while ($line = $result->fetch_assoc()) {
    $participants[] = array(
        'id' => $line['id'],
        'fname' => $line['fname'],
        'lname' => $line['lname'],
        'title' => $line['title'],
        'role' => $line['role'],
        'organization' => $line['organization'],
        'project' => $line['project'],
        'year' => $line['year'],
        'fullname' => $line['fullname'],
        'profile' => $line['profile'],
        'profile_pop' => $line['profile_pop'],
        'photo' => $line['photo'],
        'photo_aln' => $line['photo_aln'],
        'subtext' => $line['subtext'],
        'url_yt' => $line['url_yt']
    );
}

header('Content-Type: application/json');
echo json_encode($participants);
?>