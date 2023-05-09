<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$con = new mysqli("localhost", "root", "", "ap1");

// Get the 'item_name' parameter from the query string
$item_name = isset($_GET['item_name']) ? $_GET['item_name'] : '';

// Use a prepared statement with a placeholder for the item_name value
$st = $con->prepare("SELECT * FROM instruments WHERE Name = ?");
$st->bind_param("s", $item_name);

$st->execute();
$rs = $st->get_result();
$arr = array();

while ($row = $rs->fetch_assoc()) {
    array_push($arr, $row);
}

echo json_encode($arr);

?>
