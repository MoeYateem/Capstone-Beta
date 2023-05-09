<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, token, Session-ID");
if (isset($_SERVER['HTTP_SESSION_ID'])) {
    session_id($_SERVER['HTTP_SESSION_ID']); // Resume the session using the provided ID
}
session_start();
echo $_SESSION['email'];
?>