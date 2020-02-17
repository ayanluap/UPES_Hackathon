<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/rfid_user.php';
 
// instantiate database and rfid_user object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$rfid_user = new Rfid_user($db);
 
// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
 
// query rfid_users
$stmt = $rfid_user->search($keywords);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // rfid_users array
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
 
    // show products data
    echo json_encode($rfid_users_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user that no rfid user is found
    echo json_encode(
        array("message" => "No Rfid User is found with thid uid.")
    );
}


?>