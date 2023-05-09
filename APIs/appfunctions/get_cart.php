<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json"); // Set the content type to JSON

// Database connection
$con = new mysqli("localhost", "root", "", "ap1");

// Check connection
if ($con->connect_error) {
    http_response_code(500);
    echo json_encode(array("error" => "Connection failed: " . $con->connect_error));
    exit();
}

// Prepare the SQL statement
$st_check = $con->prepare("SELECT email, item_name FROM cart WHERE email = ?");

if (!$st_check) {
    http_response_code(500);
    echo json_encode(array("error" => "Prepare failed: (" . $con->errno . ") " . $con->error));
    exit();
}

// Bind the email parameter
if (!$st_check->bind_param("s", $_GET["email"])) {
    http_response_code(500);
    echo json_encode(array("error" => "Binding parameters failed: (" . $st_check->errno . ") " . $st_check->error));
    exit();
}

// Execute the SQL statement
if (!$st_check->execute()) {
    http_response_code(500);
    echo json_encode(array("error" => "Execute failed: (" . $st_check->errno . ") " . $st_check->error));
    exit();
}

// Fetch the results
$rs = $st_check->get_result();
$arr = array();
while ($row = $rs->fetch_assoc()) {
    array_push($arr, $row);
}

// Return the results as JSON
http_response_code(200);
echo json_encode($arr);

?>
