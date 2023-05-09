<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With,token");

include_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $headers = getallheaders();
    // $token = $headers['token'];

    // if($token==='mco'){
        $database = new Database();
        $conn = $database->getConnection();

        //getting the email and password of the customer
        $data = json_decode(file_get_contents("php://input"));
        $email = $data->email;
        $password = $data->password;

        $stmt = $conn->prepare("SELECT * FROM user WHERE email=:email AND password=:password");

        $stmt->execute(
            array(
                'email' => $email,
                'password' => $password,
            )
        );

        $count = $stmt->rowCount();

        if($count>0){
            session_start();
            $_SESSION['email'] = $email;
        
            $Message = "Successful login!";
            $session_id = session_id();
        }else{
            $Message = "Wrong credentials";
        }
    // }else{
    //    $Message = "Wrong Token";
    // }
    $response[] = array("Message"=>$Message, "session_id"=>$session_id);
    echo json_encode($response);
}