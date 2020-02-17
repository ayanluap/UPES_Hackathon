<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/rfid_user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare rfid user object
$rfid_user = new Rfid_user($db);
 
// set uID property of record to read
$rfid_user->id = isset($_GET['uid']) ? $_GET['uid'] : die();
 
// read the details of rfid_user to be edited
$rfid_user->readOne();
 
if($rfid_user->name!=null){
    // create array
    $rfid_user_arr = array(
        "name" => $rfid_user->name,
        "uid" =>  $rfid_user->uid,
        "phone_no" => $rfid_user->phone_no,
        "date" => $rfid_user->date,
        "time" => $rfid_user->time,
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($rfid_user_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user that this Rfid User is not exist in the database
    echo json_encode(array("message" => "This Rfid User is not exist in the Database."));
}
?>