<?php
include "connection.php";

if (isset($_POST['deletebtn'])) {
    $id = $_POST['user_id'];
    echo $id;
    $delete_query = "DELETE FROM `users` WHERE user_id=$id";
    if (mysqli_query($conn, $delete_query) == true) {
        echo "Record deleted successfully";
        header('location:viewform.php');
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>