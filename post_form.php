<?php
// DB Connection
include "connection.php";

// Get the user ID from the query string parameter
$user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;

// Check if the form has been submitted
if (isset($_POST["submit_post"])) {
  $post_caption = $_POST["caption"];
  $post_hashtag = $_POST["hashtag"];
  $post_img = $_FILES["post"]["name"];
  $allowed_extensions = ["jpg", "png", "jpeg", "gif"];
  $filename = $_FILES["post"]["name"];
  $file_extension = pathinfo($filename, PATHINFO_EXTENSION);

  // Check if the file extension is allowed
  if (!in_array($file_extension, $allowed_extensions)) {
    echo "Only jpg, jpeg, png, gif allowed!";
  } else {
    // Check if the user_id exists in the users table
    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
      echo "Invalid user ID";
    } else {
      // Fetch user data
      $user = $result->fetch_assoc();
      // $username = $user["username"];

      // Insert post data into the database
      $sql = "INSERT INTO post (user_id, post_img, post_caption, post_hashtag) VALUES ('$user_id', '$post_img', '$post_caption', '$post_hashtag')";

      if ($conn->query($sql) === true) {
        move_uploaded_file($_FILES["post"]["tmp_name"], "postdata/" . $_FILES["post"]["name"]);
        // Redirect to the view posts page
        header("Location: postview.php?user_id=" . $user_id);
        exit;
      } else {
        echo $conn->error;
      }
    }
  }
}

?>

<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <title>Social Media</title>
</head>

<body>
  <div class="container" id="PostForm">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?user_id=<?php echo $user_id; ?>" method="post"
      enctype="multipart/form-data">
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

      <h1><strong><u>CREATE POST</u></strong></h1><br>
      <br>
      <table class="table table-success table-borderless table-hover">
        <tr>
          <td><label>Post :</label></td>
          <td><input type="file" name="post" class="form-control"></td>
        </tr>
        <br><br>
        <tr>
          <td><label>Caption : </label></td>
          <td><textarea name="caption" class="form-control"></textarea></td>
        </tr>
        <br>
        <tr>
          <td><label>Hashtag : </label></td>
          <td><textarea name="hashtag" class="form-control"></textarea></td>
        </tr>
      </table>
      <br><br>
      <input type="submit" name="submit_post" class="btn btn-outline-primary" value="Post">
      <button class="btn btn-outline-success"><a href="postview.php?user_id=<?= $user_id ?>">VIEW POSTS</a></button>


    </form>
  </div>
</body>

</html>