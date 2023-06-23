<?php
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Post</title>
</head>
<style>
    h2 {
        text-align: center;
    }
</style>

<body>
    <?php

    $query = "SELECT * FROM `post` WHERE user_id='" . $_GET['user_id'] . "'";


    if ($result = $conn->query($query)) {
        ?>
        <h2>
            <marquee>POST DETAILS</marquee>
        </h2>
        <table id="searchTable" class="table">
            <tr>
                <td>

                    <button type="button" value="Add Post" class="btn btn-outline-primary"> <a
                            href="post_form.php?user_id=<?= $_GET['user_id'] ?>">Add POST</a></button>
                </td>
            </tr>
        </table>
        <table class="table table-dark  table-striped table-borderless table-hover">

            <tr>
                <th> POST ID</th>
                <th> USER ID </th>
                <th> Post IMG </th>
                <th> Caption </th>
                <th> Hashtag </th>
                <th> Action </th>
            </tr>


            <?php
            //Displaying result in the form of table
            while ($post = $result->fetch_assoc()) {
                $id = $post['user_id'];
                ?>
                <tr>
                    <td>
                        <?= $post['id'] ?>
                    </td>
                    <td>
                        <?= $post['user_id'] ?>
                    </td>
                    <td>
                        <div class="card-body">
                            <img class="card-img" src="postdata/<?= $post["post_img"] ?>" alt="error" height="200px"
                                width="50px" ;>
                            <h4 class="card-title">Posted Images</h4>
                            <!-- 
                            <a href="postview.php?user_id=<?= $user["user_id"] ?>" class="btn btn-primary mb-2">See Profile</a> -->
                        </div>

                    </td>

                    <td>
                        <?= $post["post_caption"] ?>
                    </td>
                    <td>
                        <?= $post["post_hashtag"] ?>
                    </td>
                    <td>
                        <button name="edtbtn" class="btn btn-light">
                            <a href="postedit.php?user_id=<?= $post['user_id'] ?>&post_id=<?= $post['id'] ?>"> Edit</a><br>
                        </button>
                        <!-- <button name="vpostbtn">
                                <a href="postview.php?id=<?= $post['user_id'] ?>" style='text-decoration:none;'> VIEW POSTS</a>
                            </button> -->

                        <form action="delete_post.php" method="post">
                            <input type="hidden" value="<?= $post['id'] ?>" name="id" />

                            <button name="dltbtn" type="submit" class="btn btn-danger">DELETE

                            </button>

                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
    ?>
</body>

</html>