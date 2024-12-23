<?php
include_once("./include/config.inc.php");
$data = json_decode(file_get_contents('php://input'), true);

$year = isset($data['year']) ? $data['year'] : '';
$letter = isset($data['letter']) ? $data['letter'] : '';

// ฟังก์ชันเพื่อตัดสระที่นำหน้าออก (เ, แ, โ, ไ, ใ)
function removeStartingVowel($string) {
    // สระที่ต้องการตัดออกถ้าอยู่หน้าสุด
    $vowels = ['เ', 'แ', 'โ', 'ไ', 'ใ'];

    // ตรวจสอบว่าตัวอักษรแรกเป็นสระหรือไม่ ถ้าใช่ ให้ตัดออก
    if (in_array(mb_substr($string, 0, 1, 'UTF-8'), $vowels)) {
        return mb_substr($string, 1, null, 'UTF-8'); // ตัดสระตัวแรกออก
    }
    return $string; // ถ้าไม่ใช่สระที่ต้องการตัด ก็คืนค่าเดิม
}

// ตรวจสอบและปรับตัวอักษรที่เป็น letter
$letter = removeStartingVowel($letter); // ตัดสระก่อนค้นหา

// SQL query ที่จะใช้
$query = '';
$params = [];

// การค้นหาและจัดเรียงข้อมูล
if ($year === 'all') {
    if ($letter === "all") {
        // กรณีค้นหาทั้งหมด
        $query = "SELECT * FROM students ORDER BY convert(fname USING TIS620) ASC";        
    } else {
        // กรณีค้นหาตัวอักษรแรกหลังจากตัดสระที่นำหน้า และตรวจสอบว่ามีสระนำหน้าหรือไม่
        $query = "SELECT * FROM students WHERE LEFT(fname, 1) = ? OR LEFT(fname, 2) = ? OR LEFT(fname, 2) = ? OR LEFT(fname, 2) = ? OR LEFT(fname, 2) = ? OR LEFT(fname, 2) = ? ORDER BY convert(fname USING TIS620) ASC";
        $params[] = $letter; // กรณีไม่มีสระนำหน้า
        $params[] = 'เ' . $letter; // กรณีมีสระ เ นำหน้า
        $params[] = 'แ' . $letter; // กรณีมีสระ แ นำหน้า
        $params[] = 'โ' . $letter; // กรณีมีสระ โ นำหน้า
        $params[] = 'ไ' . $letter; // กรณีมีสระ ไ นำหน้า
        $params[] = 'ใ' . $letter; // กรณีมีสระ ใ นำหน้า
    }
} else {
    if ($letter === "all") {
        // กรณีค้นหาทั้งหมดตามปีที่เลือก
        $query = "SELECT * FROM students WHERE year = ? ORDER BY convert(fname USING TIS620) ASC";
        $params[] = $year;
    } else {
        // กรณีค้นหาตัวอักษรแรกตามปีที่เลือก และตรวจสอบว่ามีสระนำหน้าหรือไม่
        $query = "SELECT * FROM students WHERE year = ? AND (LEFT(fname, 1) = ? OR LEFT(fname, 2) = ? OR LEFT(fname, 2) = ? OR LEFT(fname, 2) = ? OR LEFT(fname, 2) = ? OR LEFT(fname, 2) = ?) ORDER BY convert(fname USING TIS620) ASC";
        $params[] = $year;
        $params[] = $letter; // กรณีไม่มีสระนำหน้า
        $params[] = 'เ' . $letter; // กรณีมีสระ เ นำหน้า
        $params[] = 'แ' . $letter; // กรณีมีสระ แ นำหน้า
        $params[] = 'โ' . $letter; // กรณีมีสระ โ นำหน้า
        $params[] = 'ไ' . $letter; // กรณีมีสระ ไ นำหน้า
        $params[] = 'ใ' . $letter; // กรณีมีสระ ใ นำหน้า
    }
}

// การเตรียม statement
$stmt = $conn->prepare($query);

if ($params) {
    // ผูกค่าพารามิเตอร์กับ statement
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$students = array();

// จัดการผลลัพธ์
while ($line = $result->fetch_assoc()) {
    $students[] = array(
        'name' => $line['name'],
        'photo_aln' => $line['photo_aln'],
        'year' => $line['year'],
        'url' => $line['url'],
    );
}

// ส่งกลับเป็น JSON
header('Content-Type: application/json');
echo json_encode($students);