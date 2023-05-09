<?php
header("Access-Control-Allow-Origin: *"); // Replace * with the specific domain if desired
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$con=new mysqli("localhost","root","","ap1");

if (isset($_POST['cartadd'])){
    $st_check=$con->prepare("insert into cart values(?,?)");
    $st_check->bind_param("ss", $_POST["email"],$_POST["item_name"]);
    $st_check->execute();
}

?>
