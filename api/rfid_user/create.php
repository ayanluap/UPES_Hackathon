<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate rfid user object
include_once '../objects/rfid_user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$rfid_user = new Rfid_user($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// making sure that data is not empty
if(
    !empty($data->name) &&
    !empty($data->uid) &&
    !empty($data->phone_no) &&
    !empty($data->date) &&
    !empty($data->time)
){
 
    // set rfid user property values
    $rfid_user->name = $data->name;
    $rfid_user->uid = $data->uid;
    $rfid_user->phone_no = $data->phone_no;
    $rfid_user->date = $data->date;
    $rfid_user->time = $data->time;
 
    // create new rfid user
    if($rfid_user->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Rfid User is created."));
    }
 
    // if unable to create rfid user, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create Rfid User."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create Rfid User. Data is incomplete."));
}
?>