<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/rfid_user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare rfid_user object
$rfid_user = new Rfid_user($db);
 
// get rfid_user uid
$data = json_decode(file_get_contents("php://input"));
 
// set rfid_user uid to be deleted
$rfid_user->uid = $data->uid;
 
// delete the rfid_user
if($rfid_user->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Rfid User is deleted."));
}
 
// if unable to delete the rfid user's data
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to delete Rfid User."));
}
?>