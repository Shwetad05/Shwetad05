<?php
include("connection.php");
include "cascadingDropDown.php";

$country = '';
if (isset($_GET['id'])) {


  $id = $_GET['id'];
  $query = "SELECT * FROM users WHERE user_id= $id";

  $result = mysqli_query($conn, $query);
  // $editData = mysqli_fetch_assoc($result);

  while ($row = $result->fetch_assoc()) {
    $first_name = $row["first_name"];
    $last_name = $row["last_name"];
    $user_name = $row["user_name"];
    $email = $row["email"];
    $password = $row["password"];
    $gender = $row["gender"];
    $countryUser = $row["country"];
    $userState = $row["state"];
    $userCity = $row["city"];
    // var_dump($userCity);
    // exit;
    $bio = $row["bio"];
    $profile = $row["profile"];
    $social_media_str = $row["social_media"];
    $social_media = explode(",", $social_media_str);

  }
}
if (isset($_POST['update'])) {

  $id = $_GET['id'];
  $user_id = $_GET['user_id'];
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $user_name = $_POST["user_name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $gender = $_POST["gender"];
  $country = $_POST["country"];

  $state = $_POST["state"];
  $city = $_POST["city"];
  $bio = $_POST["bio"];
  $profile = $_FILES["profile"]["name"];
  $tmp = explode('.', $profile);
  $file_extension = end($tmp);
  // exit();
  // $social_media=$_POST["social_media"];
  $social_media = implode(",", $_POST["social_media"]);

  //profilephoto

  // if(isset($_POST['submit'])) {
//   $user_id = $_SESSION['user_id'];
  $extensions = array("jpeg", "jpg", "png");

  if (in_array($file_extension, $extensions) === false) {
    $errors[] = "Extension error,please choose correct file type";
  }

  if ($profile) {
    move_uploaded_file($_FILES['profile']['tmp_name'], 'uploads/' . $profile);
  } else {
    echo "Error updating...!!";
  }

  $update_query = "UPDATE `users` SET `first_name`='$first_name',`last_name`='$last_name',`user_name`='$user_name',`email`='$email',`password`='$password',`gender`='$gender',`country`='$country',`state`='$state',`city`='$city',`bio`='$bio',`social_media`='$social_media' ,`profile`='$profile' WHERE user_id=$id";
  if (mysqli_query($conn, $update_query) == true) {
    header('location:viewform.php');
  }
}

//Fetch Countries for Options
$countryOptions = '<option value="">Select Country</option>';
$query = "SELECT * FROM countries";
$countries = $conn->query($query);
if ($countries->num_rows > 0) {

  while ($country = $countries->fetch_assoc()) {
    if ($countryUser == $country['name']) {
      $countryOptions .= '<option value=' . $country['name'] . ' data-id=' . $country['id'] . ' selected>' . $country['name'] . '</option>';
    } else {
      $countryOptions .= '<option value=' . $country['name'] . ' data-id=' . $country['id'] . '>' . $country['name'] . '</option>';
    }
  }
}

//Fetch state for Options
$stateOptions = '<option value="">Select State</option>';
$query = "SELECT s.* FROM states as s,countries as c where s.country_id = c.id and c.name like '" . $countryUser . "'";
// var_dump($userState);
// die;
$states = $conn->query($query);
if ($states->num_rows > 0) {

  while ($state = $states->fetch_assoc()) {
    if ($userState == $state['name']) {

      $stateOptions .= '<option value=' . $state['name'] . ' data-id=' . $state['id'] . ' selected>' . $state['name'] . '</option>';
    } else {

      $stateOptions .= '<option value=' . $state['name'] . ' data-id=' . $state['id'] . '>' . $state['name'] . '</option>';
    }
  }
}

//Fetch city for Options
$cityOptions = '<option value="">Select City</option>';
$query = "SELECT c.* FROM cities as c,states as st where c.state_id = st.id and st.name like '" . $userState . "'";
// var_dump($userCity);
// die;
$citis = $conn->query($query);
if ($citis->num_rows > 0) {

  while ($city = $citis->fetch_assoc()) {
    if ($userCity == $city['name']) {
      // var_dump($userCity);
      // die();
      $cityOptions .= '<option value=' . $city['name'] . ' data-id=' . $city['id'] . ' selected>' . $city['name'] . '</option>';
    } else {
      $cityOptions .= '<option value=' . $city['name'] . ' data-id=' . $city['id'] . '>' . $city['name'] . '</option>';
    }
  }
}

?>

<!-- ?> -->




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <title>Social_Media</title>
  <script type="text/javascript">
    function FetchState(id) {
      $('#state').html('');
      $('#city').html('<option>Select City</option>');
      console.log("stateFetch");
      console.log(id);
      $.ajax({
        type: 'post',
        url: 'cascadingDropDown.php',
        data: { country_id: id },
        success: function (data) {
          console.log(data);
          $('#state').html(data);
        }

      })
    }

    function FetchCity(id) {
      $('#city').html('');
      $.ajax({
        type: 'post',
        url: 'cascadingDropDown.php',
        data: { state_id: id },
        success: function (data) {
          $('#city').html(data);
        }

      })
    }
    $(document).ready(function () {


      $('#country').on('change', function () {
        let id = $(this).find(':selected').data('id');
        FetchState(id);
      });

      $('#state').on('change', function () {
        let id = $(this).find(':selected').data('id');
        FetchCity(id);
      });

    });

  </script>
  <style>
    .form-control {
      width: unset;
    }
  </style>
</head>

<body>
  <!-- ADD form Data-->
  <div class="container" id="RegForm">
    <form action="" method="post" enctype="multipart/form-data">
      <h1><strong><u>USER_REGISTRATION_FORM</u></strong></h1><br>
      <br>
      <table class="table table-success table-borderless ">
        <tr>
          <td> <label>First Name :</label></td>
          <td> <input type="text" name="first_name" class="mb-2" value="<?php echo $first_name ?>"></td>
        </tr>
        <tr>
          <td><label> Last Name : </label></td>
          <td><input type="text" name="last_name" class="mb-2" value="<?php echo $last_name ?>"></td>
        </tr>
        <tr>
          <td> <label> User Name : </label></td>
          <td><input type="text" name="user_name" class=" form control mb-2" value="<?php echo $user_name ?>"></td>
        </tr>
        <tr>
          <td> <label> Email :</label></td>
          <td> <input type="email" name="email" class="mb-2" value="<?php echo $email ?>"></td>
        </tr>
        <tr>
          <td><label>Password : </label></td>
          <td><input type="password" name="password" class="mb-2 " value="<?php echo $password ?>"></td>
        </tr>
        <tr>
          <td><label>Gender: </label></td>
          <td><input type="radio" name="gender" <?php if (isset($gender) && $gender == "female")
            echo "checked"; ?>
              value="female">Female
            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "male")
              echo "checked"; ?>
              value="male">Male
            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "other")
              echo "checked"; ?>
              value="other">Other
          </td>
        </tr>
        <tr>

          <td><label> Country: </label></td>
          <td>
            <select name="country" id="country" class="form-select" <?php if (isset($country) && $country == ".find:selected ")
              echo "selected"; ?>required>
              <?php echo $countryOptions; ?>
            </select>
          </td>
        </tr>


        <tr>
          <td><label> State: </label></td>
          <td>
            <select name="state" id="state" class="form-select" required>
              <?php echo $stateOptions; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><label> City: </label></td>
          <td>
            <select name="city" id="city" class="form-select" required>
              <?php echo $cityOptions; ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><label>Bio: </label></td>
          <td><textarea name="bio" class="form-control"><?php echo $bio ?></textarea></td>

        </tr>
        <tr>
          <td><label> Profile : </label></td>
          <td><input id="profile" type="file" name="profile" placeholder="Photo"></td>
        </tr>
        <tr>
          <?php
          // print_r($social_media);
          

          ?>
          <td><label> Active Social Media : </label></td>
          <td><input type="checkbox" class="form-check-input" id="check1" name="social_media[]" value="Instagram" <?php if (in_array("Instagram", $social_media))
            echo ("Checked"); ?>>
            <label class="form-check-label" for="check1">Instagram</label>
          </td>

        </tr>
        <tr>
          <td></td>
          <td>
        <tr>
          <td></td>
          <td><input type="checkbox" class="form-check-input" id="check2" name="social_media[]" value="twitter" <?php if (in_array("twitter", $social_media))
            echo ("Checked"); ?>>
            <label class="form-check-label" for="check2">Twitter</label>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check3" name="social_media[]" value="LinkedIN" <?php if (in_array("LinkedIN", $social_media))
                echo ("Checked"); ?>>
              <label class="form-check-label" for="check2">LinkedIN</label>
            </div>
          </td>
        <tr>
          <td></td>
          <td>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check4" name="social_media[]" value="facebook" <?php if (in_array("facebook", $social_media))
                echo ("Checked"); ?>>
              <label class="form-check-label" for="check2">Facebook</label>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check5" name="social_media[]" value="whatsapp" <?php if (in_array("whatsapp", $social_media))
                echo ("Checked"); ?>>
              <label class="form-check-label" for="check2">Whatsapp</label>
          </td>
        </tr>
        <tr>

  </div>
  </div>
  </tr>
  </table>
  <!-- Submit button -->
  <div class="col mb-2">
    <input type="submit" class="btn btn-primary btn-block mb-4" name="update" value="Update">

    </form>
</body>

</html>