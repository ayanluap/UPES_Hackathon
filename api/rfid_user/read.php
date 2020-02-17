<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/rfid_user.php';
 
// instantiate database and rfid user object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$rfid_user = new Rfid_user($db);
 
// read products will be here
// query of rfid user
$stmt = $rfid_user->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // rfid users array
    $rfid_users_arr=array();
    $rfid_users_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $rfid_user_item=array(
            "name" => $name,
            "uid" => $uid,
            "phone_no" => $phone_no,
            "date" => $date,
            "time" => $time
        );
 
        array_push($rfid_users_arr["records"], $rfid_user_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show rfid user's data in json format
    echo json_encode($rfid_users_arr);
}
 
// no products found will be here
else{
 
  // set response code - 404 Not found
  http_response_code(404);

  // tell the user no products found
  echo json_encode(
      array("message" => "No Rfid User is found.")
  );
}