<?php


$servername = "localhost";
$username = 'root';
$password = '';
$dbname = 'social_media';

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// //create db 
// $sql="CREATE DATABASE Social_Media";
// if($conn->query($sql)===TRUE){
//     echo"DB created successfully";
// }else{
//     echo"error creating database".$conn->error;
// }


// CREATE TABLE users( user_id int PRIMARY KEY AUTO_INCREMENT, first_name VARCHAR(50) not null, 
// last_name VARCHAR(50) not null , user_name varchar(50) not null, email VARCHAR(100) not null, password varchar(50)
// not null, gender ENUM("male","female","other") not null, country varchar(50) not null, state varchar(50) not null,
//  city varchar(50) not null, bio varchar(250) not null, profile varchar(250) not null, social_media varchar(50) not null );

?>