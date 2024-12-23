<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once("include/config.inc.php");

$sql = "SELECT name, year, mapCamp FROM tb_campYear WHERE status = 1 ORDER BY sort ASC";
$result = $conn->query($sql);

$years = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $years[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($years);
?>
