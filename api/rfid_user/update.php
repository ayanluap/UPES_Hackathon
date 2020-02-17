<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/rfid_user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare rfid_user object
$rfid_user = new Rfid_user($db);
 
// get id of rfid_user to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set uID property of rfid user to be edited
$rfid_user->uid = $data->uid;
 
// set rfid_user property values
$rfid_user->name = $data->name;
$rfid_user->phone_no = $data->phone_no;
$rfid_user->date = $data->date;
$rfid_user->time = $data->time;
 
// update the rfid_user
if($rfid_user->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Rfid User is updated."));
}
 
// if unable to update the rfid user's data, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update Rfid User."));
}
?>