<?php
//DB Connection
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get the button:
let mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop >100 || document.documentElement.scrollTop > 100) {
    mybutton.style.display = "block";
  } 
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
    </script>
    <title>form_VIEW</title>
    <style>
        h1 {
            text-align: center;
        }
       
    </style>
</head>

<body>
    <?php
    //VIEW QUERY
    $asql = "SELECT * FROM users";
    // }
    
    if ($result = $conn->query($asql)) {
        ?>

        <h1><u>
                <marquee>USERS LIST</marquee>
            </u></h1>
        <button id="AddBtn" class="btn btn-info" onclick="window.location.href = 'USER_REGISTRATION_FORM.php';"> Add
            User</a></button>
        <br><br>
        <div class=".table-responsive">
            <table class="table table-dark table-striped table-borderless table-hover">
                <tr>
                    <th> USER_ID </th>
                    <th> FIRSTNAME </th>
                    <th> LASTNAME </th>
                    <th> USERNAME </th>
                    <th> EMAIL </th>
                    <th> GENDER </th>
                    <th> COUNTRY </th>
                    <th> STATE </th>
                    <th> CITY </th>
                    <th> BIO </th>
                    <th> PROFILE </th>
                    <th> SOCIAL_MEDIA </th>
                    <th> ACTION </th>
                </tr>
                </thead>

                <?php
                //Display result in table view
                while ($user = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td>
                            <?= $user["user_id"] ?>
                        </td>
                        <td>
                            <?= $user["first_name"] ?>
                        </td>
                        <td>
                            <?= $user["last_name"] ?>
                        </td>
                        <td>
                            <?= $user["user_name"] ?>
                        </td>
                        <td>
                            <?= $user["email"] ?>
                        </td>
                        <td>
                            <?= $user["gender"] ?>
                        </td>
                        <td>
                            <?= $user["country"] ?>
                        </td>
                        <td>
                            <?= $user["state"] ?>
                        </td>
                        <td>
                            <?= $user["city"] ?>
                        </td>
                        <td>
                            <?= $user["bio"] ?>
                        </td>
                        <div class=card>
                            <td>
                                <div class="card-body" style="width: 18rem;">
                                    <img class="card-img img-thumbnail" src="uploads/<?= $user["profile"] ?>" alt="error"
                                        height="400px" width="400px" ;>
                                    <h4 class="card-title">User Profile Photo</h4>

                                    <a href="postview.php?user_id=<?= $user["user_id"] ?>" class="btn btn-primary mb-2">See
                                        Profile</a>
                                </div>



                            </td>
                        </div>
                        <td>
                            <?= $user["social_media"] ?>
                        </td>
                        <td>

                            <form action="delete.php" method="post">
                                <input type="hidden" value="<?= $user['user_id'] ?>" name="user_id" />
                                <button name="edtbtn" class="btn btn-light"> <a href="edit.php?id=<?= $user['user_id'] ?>"> Edit
                                    </a></button><br>
                                <input type="submit" value="DELETE" name="deletebtn" class="btn btn-danger" />
                                <br>
                                <button name="view_btn" class="btn btn-info"> <a
                                        href="postview.php?user_id=<?= $user["user_id"] ?>"> VIEW POSTS </a></button>
                        </td>
                        </form>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <button onclick="topFunction()"  class="btn btn-info" id="myBtn" title="Go to top"><span>Back To Top</span></button>

        </div>
        <?php
    } else {
        echo "Error!";
    }
    ?>
</body>

</html>