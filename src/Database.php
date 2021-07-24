<?php 

namespace App; 

use PDO;

class Database
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $dbconn;
    
    function __construct()
    {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->password = '';
        $this->database = 'dbuser';
        $this->dbconn = null;
    }

    public function connect()
    {
        try {
            $this->dbconn = new PDO('mysql:host='.$this->host.';dbname='.$this->database.'', $this->user, $this->password) or die("Cannot connect to MySQL.");
            // set the PDO error mode to exception
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Database connected successfully";

            return $this->dbconn;
        } catch(PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
            die();
        }
    }

    /** Insert user data into database */
    public function insert($data) {
        $this->connect();
        $password = sha1($data->getPassword());
        $stmt = $this->dbconn->prepare("INSERT INTO tbl_user(first_name, last_name, email, password, dob, country, photo) 
            VALUES (:first_name, :last_name, :email, :password, :dob, :country, :photo)");
        
        $stmt->bindParam(':first_name', $data->getFirstName());
        $stmt->bindParam(':last_name', $data->getLastName());
        $stmt->bindParam(':email', $data->getEmail());
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':dob', $data->getDob());
        $stmt->bindParam(':country', $data->getCountry());
        $stmt->bindParam(':photo', $data->getPhoto());

        // insert a row
        if($stmt->execute()){
            $result =1;
        }   

        $this->dbconn = null;

        return true;
    }

    /** chek if email is unique or not */
    public function checkUniquEmail($email) {
       
        $this->connect();
        $query = $this->dbconn->prepare( "SELECT `email` FROM `tbl_user` WHERE `email` = :email" );
        $query->bindValue(':email', $email );
        $query->execute();

        if($query->rowCount() > 0) { # If rows are found for query
            return true;
        } else {
            return false;
        }

        $this->dbconn = null;
    }
}