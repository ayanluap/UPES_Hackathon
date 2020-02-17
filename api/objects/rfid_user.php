<?php
class Rfid_user{
 
    // database connection and table name

    private $conn;
    private $table_name = "rfid_users";
 
    // object properties
    
    public $name;
    public $uid;
    public $phone_no;
    public $date;
    public $time;

    // constructor with $db as database connection

    public function __construct($db){
        $this->conn = $db;
    }

    // read rfid users

    function read(){
 
    // select all query
        $query = "SELECT
                *
                FROM
                    " . $this->table_name . "
                ORDER BY
                    uid DESC";
 
    // prepare query statement
        $stmt = $this->conn->prepare($query);
 
    // execute query
        $stmt->execute();
 
        return $stmt;
    }

    function create(){
 
    // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, uid=:uid, phone_no=:phone_no, date=:date, time=:time";
 
    // prepare query
        $stmt = $this->conn->prepare($query);
 
    // sanitize from errors or harmful script
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->uid=htmlspecialchars(strip_tags($this->uid));
        $this->phone_no=htmlspecialchars(strip_tags($this->phone_no));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->time=htmlspecialchars(strip_tags($this->time));
 
    // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":uid", $this->uid);
        $stmt->bindParam(":phone_no", $this->phone_no);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":time", $this->time);
 
    // execute query
        if($stmt->execute()){
            return true;
        }
 
        return false;
     
    }

// used when filling up the update rfid user form

    function readOne(){
 
    // query to read single record
        $query = "SELECT
                *
                FROM
                    " . $this->table_name . "
                WHERE
                    uid = ?
                LIMIT
                    0,1";
 
    // prepare query statement
        $stmt = $this->conn->prepare( $query );
 
    // bind uid of rfid user to be updated
        $stmt->bindParam(1, $this->uid);
 
    // execute query
        $stmt->execute();
 
    // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
        $this->name = $row['name'];
        $this->uid = $row['uid'];
        $this->phone_no = $row['phone_no'];
        $this->date = $row['date'];
        $this->time = $row['time'];
    }

// update the rfid user

    function update(){
 
    // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    phone_no = :phone_no,
                    date = :date,
                    time = :time
                WHERE
                    uid = :uid";
 
    // prepare query statement
        $stmt = $this->conn->prepare($query);
 
    // sanitize from errors and harmful script
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->phone_no=htmlspecialchars(strip_tags($this->phone_no));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->time=htmlspecialchars(strip_tags($this->time));
        $this->uid=htmlspecialchars(strip_tags($this->uid));
 
    // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':phone_no', $this->phone_no);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':time', $this->time);
        $stmt->bindParam(':uid', $this->uid);
 
    // execute the query
        if($stmt->execute()){
            return true;
        }
 
        return false;
    }

// delete the rfid user detail

    function delete(){
 
    // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE uid = ?";
 
    // prepare query
        $stmt = $this->conn->prepare($query);
 
    // sanitize from error and harmful scripts
        $this->uid=htmlspecialchars(strip_tags($this->uid));
 
    // bind uid of record to delete
        $stmt->bindParam(1, $this->uid);
 
    // execute query
        if($stmt->execute()){
            return true;
        }
 
        return false;
     
    }

// search rfid users

    function search($keywords){
 
    // select all query
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
                    name LIKE ? OR phone_no LIKE ? OR uid LIKE ?
                ORDER BY
                    uid DESC";
 
    // prepare query statement
        $stmt = $this->conn->prepare($query);
 
    // sanitize from errors and harmful scripts
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
 
    // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
 
    // execute query
        $stmt->execute();
 
        return $stmt;
    }

}
?>