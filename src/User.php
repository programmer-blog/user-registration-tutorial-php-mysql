<?php

 /**
 * @description: User class create a new user.
 */

namespace App;
//use DB;
use App\DB;

class User {

   private $first_name;
   private $last_name;
   private $email;
   private $password;
   private $confirm_password;
   private $dob;
   private $country;
   private $photo;
   private $error;

  /** Assign the data to properties */
  public function __construct($user) {
    $this->first_name = $user['first_name'];
    $this->last_name = $user['last_name'];
    $this->email = $user['email'];
    $this->password = $user['password'];
    $this->confirm_password = $user['conf_password'];
    $this->dob = $user['dob'];
    $this->country = $user['country'];
    $this->terms = $user['terms'];
    $this->error = null;
  }

  public function setPhoto($photo) {
    $this->photo = $photo; 
  }

  /** Validate user entered data */
  public function validate(){
    /** Validate Name */
    if (!$this->first_name || !$this->last_name) {
      $this->error .= "<li>First and Last name are mandatory.</li>";
    }

    /** Validate Email */
    if(!$this->email) {
      $this->error .= "<li>Email cannot be left blank.</li>";
    } elseif (!strpos($this->email, '@') || !strpos($this->email, '.')) {
      $this->error .= "<li>Enter a valid email.</li>";   
    } else { 
      $db = new database();
      if($db->checkUniquEmail($this->email)) {
        $this->error .= "<li>Email already exists!. Try another.</li>";   
      }
    }

    /** Validate Password */
    if (!$this->password || !$this->confirm_password) {
      $this->error .= "<li>Password and confirm password are required.</li>";
    } elseif(strlen($this->password) <6){
      $this->error .= "<li>Password must be atleast 6 characters long.</li>";
    } elseif($this->password !== $this->confirm_password) {
      $this->error .= "<li>Password and confirm password donot match</li>";
    } 

    /** Validate Date of Birth */
    if (!$this->dob) {
      $this->error .= "<li>Date of Birth is mandatory.</li>";
    }

    /** Validate Date of Birth */
    if (!$this->country) {
      $this->error .= "<li>Country is mandatory.</li>";
    }

    /** Validate Terms */
    if (!$this->terms) {
      $this->error .= "<li>Please accept terms and conditions</li>";
    }

    return $this->error;
  }

  public function getFirstName() {
    return $this->first_name; 
  }

  public function getLastName() {
    return $this->last_name;
  }

  public function getEmail() {
    return $this->email; 
  }

  public function getPassword() {
    return $this->password;
  }

  public function getDob() {
    return $this->dob; 
  }

  public function getCountry() {
    return $this->country;
  }

  public function getPhoto() {
    return $this->photo;
  }
  //insert into database a new user
  public function insert() { 
    $db = new database();
    
    return $db->insert($this);
  }
}