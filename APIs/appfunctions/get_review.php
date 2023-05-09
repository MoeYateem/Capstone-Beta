<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, token, Session-ID");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  exit;
}
$conn = new mysqli("localhost", "root", "", "ap1");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve reviews function
function getReviews($instrument_name) {
  global $conn;

  // Query to retrieve all reviews for the given instrument
  $query = "SELECT * FROM reviews WHERE instrument_name ='$instrument_name'";

  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    // Reviews found, return them as an array
    $reviews = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $reviews[] = $row;
    }
    return $reviews;
  } else {
    // No reviews found
    return "No reviews found for this instrument.";
  }
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Get instrument name parameter from query string
  $instrument_name = $_GET['instrument_name'];

  // Call getReviews function and send response
  $response = getReviews($instrument_name);
  echo json_encode($response);
}
?>