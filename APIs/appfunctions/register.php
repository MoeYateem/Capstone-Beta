<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With,token");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../objects/customer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $headers = getallheaders();
    // $token = $headers['token'];

    $database = new Database();
    $db = $database->getConnection();
    $item = new customer($db);
    $data = json_decode(file_get_contents("php://input"));

    // Check if email already exists
    if (emailExists($db, $data->email)) {
        $response = array("Message" => "Email already exists.");
    } else {
        $item->fname = $data->fname;
        $item->lname = $data->lname;
        $item->email = $data->email;
        $item->password = $data->password;

        if ($item->createCustomer()) {
            $response = array("Message" => "You have successfully registered!");
        } else {
            $response = array("Message" => "Failed to register, try again later.");
        }
    }

    echo json_encode($response);
}

function emailExists($db, $email)
{
    $query = "SELECT email FROM user WHERE email = :email LIMIT 1";

    $stmt = $db->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $numRows = $stmt->rowCount();

    return ($numRows > 0);
}
?>
