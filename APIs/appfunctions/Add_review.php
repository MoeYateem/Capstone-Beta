<?php

// Establish database connection


$conn = new mysqli("localhost","root","","ap1");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Add review function
function addReview($instrument_name, $email, $review) {
  global $conn;
  

  // Check if user has already reviewed this instrument
  $check_query = "SELECT * FROM reviews WHERE email = '$email' AND instrument_name = '$instrument_name'";
  $check_result = mysqli_query($conn, $check_query);

  if (mysqli_num_rows($check_result) > 0) {
    return "User has already reviewed this instrument.";
  } else {
    // Insert new review and rating
    $insert_query = "INSERT INTO reviews (email, instrument_name, review) VALUES ('$email', '$instrument_name', '$review')";

    if (mysqli_query($conn, $insert_query)) {
      return "Review added successfully.";
    } else {
      return "Error: " . mysqli_error($conn);
    }
  }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get request body parameters
  $instrument_name = $_POST['instrument_name'];
  $email = $_POST['email'];
  $review = $_POST['review'];

  // Call addReview function and send response
  $response = addReview($instrument_name, $email, $review);
  echo $response;
}

?>
