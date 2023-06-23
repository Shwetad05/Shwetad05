<?php
include "connection.php";

if (isset($_POST['dltbtn'])) {
  $referer = $_SERVER['HTTP_REFERER'];
  $id = $_POST['id'];

  $delete_query = "DELETE FROM `post` WHERE id=$id";
  $ts = mysqli_query($conn, $delete_query);
  echo $ts;

  if ($ts == 1) {
    echo "Record deleted successfully";
    // header('location:postview.php');
    echo '<script>alert("Post deleted successfully")</script>';
    header("Location: $referer");
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
  }

}
?>