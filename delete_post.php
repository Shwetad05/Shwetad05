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

if(isset($_POST['deletebtn'])){
    $id = $_POST['user_id'];
    echo $id;
     $delete_query="DELETE FROM `post` WHERE user_id=$id";
    if( mysqli_query($conn, $delete_query)==true){
        echo "Record deleted successfully";
            header('location:postview.php');
           } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
    }
    ?>