<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ap1";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// select columns from the instruments table
$sql = "SELECT name, type, price, pic FROM instruments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $instruments = array();

    // loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // extract the instrument details
        $name = $row["name"];
        $type = $row["type"];
        $price = $row["price"];
        $pic = $row["pic"];

        // create an instrument array
        $instrument = array(
            "name" => $name,
            "type" => $type,
            "price" => $price,
            "pic" => $pic
        );

        // add the instrument to the instruments array
        $instruments[] = $instrument;
    }

    // return the instruments as JSON
    echo json_encode($instruments);
} else {
    echo json_encode(array());
}

// close the connection
$conn->close();
?>
