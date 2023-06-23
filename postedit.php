<?php
include "connection.php";
$user_id = $_GET['user_id'];
$post_id = $_GET['post_id'];
// Check if the form is submitted
if (isset($_POST["updatepost"])) {
    // $user_id=$_POST['user_id'];
    // $post_img=$_POST['post_img'];
    $post_img = $_FILES['post_img']['name'];
    $caption = $_POST['post_caption'];
    $hashtag = $_POST['post_hashtag'];

    // Check if a new image is uploaded
    if (isset($_FILES['post_img']['name']) && $_FILES['post_img']['name'] != '') {
        $post_img = $_FILES['post_img']['name'];
        $target_dir = "postdata/";
        $target_file = $target_dir . basename($post_img);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extensions = array("jpeg", "jpg", "png");

        if (!in_array($file_extension, $extensions)) {
            $errors[] = "Extension error,please choose correct file type";
        }
        // Check if the file is an image
        if (getimagesize($_FILES['post_img']['tmp_name'])) {
            // Upload the file
            if (move_uploaded_file($_FILES["post_img"]["tmp_name"], $target_file)) {
                // Update the post details in the database
                $update_query = "UPDATE post SET post_img='$post_img', post_caption='$caption', post_hashtag='$hashtag' WHERE id=$post_id";
                //    echo $update_query;
                //    die();
                // $referer = $_SERVER['HTTP_REFERER'].'user_id='.$user_id;
                if ($conn->query($update_query) === TRUE) {
                    echo "Post updated successfully";
                    header("Location: postview.php?user_id=" . $user_id . "&post_id=" . $post_id);
                    exit;
                } else {
                    echo "Error updating post: " . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }

    }
}


// Retrieve the post details from the database
$query = "SELECT * FROM post WHERE id=$post_id";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($post = $result->fetch_assoc()) {
        // print_r( $post);
        // $post_img = $post['post_img'];
        $post_caption = $post['post_caption'];
        $post_hashtag = $post['post_hashtag'];
    }
}
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container" id="Postedit">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <h1><strong><u>CREATE POST</u></strong></h1><br>
            <br>
            <table class="table table-success table-borderless table-hover">
                <tr>
                    <td> <label>Post :</label></td>
                    <td> <input type="file" name="post_img" class="form-control" value="<?php echo $post_img ?>"></td>
                </tr><br><br>
                <tr>
                    <td><label> Caption : </label></td>

                    <td><textarea name="post_caption" class="form-control"><?= $post_caption ?></textarea></td>
                </tr><br>
                <tr>
                    <td><label>Hashtag </label></td>
                    <td><textarea name="post_hashtag" class="form-control" value=""><?= $post_hashtag ?></textarea></td>

                </tr>

                <input type="submit" class="btn btn-primary" name="updatepost" value="UPDATE POST">




                </button>

    </div>
    </tr>
    </table>
    </form>
</body>

</html>