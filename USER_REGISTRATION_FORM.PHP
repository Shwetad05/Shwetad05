<?php
//DB Connection
include "connection.php";
include "cascadingDropDown.php";
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
  if(isset($_POST['submit']) ){
  //   echo 'here';
  //   var_dump($_FILES['profile']);
  //   die();
  // }
  // $profile = $_FILES["profile"];

  // Retrieve form data
  // $user_id = $_GET["user_id"];
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $User_name = $_POST["User_name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $gender = $_POST["gender"];
  $country = $_POST["country"];
  $state = $_POST["state"];
  $city = $_POST["city"];
  $bio = $_POST["bio"];
  $profile=$_FILES["profile"]["name"];
  $tmp = explode('.', $profile);
  $file_extension = end($tmp);
  // var_dump($profile);
  // exit();
  $social_media = $_POST['social_media'] ?? [];
  $social_media = implode(",", $social_media);
  
  $extensions = array("jpeg","jpg","png");

  if(in_array($file_extension,$extensions)===false){
    $errors[]="Extension error,please choose correct file type";
  }
  {
    if($profile)
    {
        move_uploaded_file($_FILES['profile']['tmp_name'], 'uploads/'.$profile);
    }
  }

  // Insert data into database
  $sql = "INSERT INTO users (first_name, last_name, User_name, email, password, gender, country, state, city, bio,profile,social_media)
          VALUES ('$first_name', '$last_name', '$User_name', '$email', '$password', '$gender', '$country', '$state', '$city', '$bio','$profile','$social_media')";
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  }
  // Close database connection
  // $conn->close();
}

//Fetch Countries for Options
$countryOptions = '<option value="">Select Country</option>';
$query = "SELECT * FROM countries";
$countries = $conn->query($query);
if ($countries->num_rows > 0 ) {

    while ($country = $countries->fetch_assoc()) {
      $countryOptions .= '<option value='.$country['name'].' data-id='.$country['id'].'>'.$country['name'].'</option>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript">
  function FetchState(id){
    $('#state').html('');
    $('#city').html('<option>Select City</option>');
    console.log("stateFetch");
    console.log(id);
    $.ajax({
      type:'post',
      url: 'cascadingDropDown.php',
      data : { country_id : id},
      success : function(data){
        console.log(data);
         $('#state').html(data);
      }

    })
  }

  function FetchCity(id){ 
    $('#city').html('');
    $.ajax({
      type:'post',
      url: 'cascadingDropDown.php',
      data : { state_id : id},
      success : function(data){
         $('#city').html(data);
      }

    })
  }
$(document).ready(function() {
  

  $('#country').on('change',function(){
    let id = $(this).find(':selected').data('id');
    FetchState(id);
  });

  $('#state').on('change',function(){
    let id = $(this).find(':selected').data('id');
     FetchCity(id);
  });
  
});
  
</script>
  <title>Social_Media</title>
  <style>
    .form-control {
      width: unset;
    }

  </style>
</head>

<body>
  <div class="container mt-3">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" >
      <h1><strong><u>USER_REGISTRATION_FORM</u></strong></h1><br>
      <br>
      <table class="table table-success table-borderless ">
        
        <tr>
          <td> <label>First Name :</label></td>
          <td> <input type="text" name="first_name" class="form-control mb-3"></td>
        </tr>
        <tr>
          <td><label> Last Name : </label></td>
          <td><input type="text" name="last_name" class="form-control mb-3"></td>
        </tr>
        <tr>
          <td> <label> User Name : </label></td>
          <td><input type="text" name="User_name" class="form-control mb-3"></td>
        </tr>
        <tr>
          <td> <label> Email :</label></td>
          <td> <input type="email" name="email" class="form-control mb-3"></td>
        </tr>
        <tr>
          <td><label>Password : </label></td>
          <td><input type="password" name="password" class="form-control mb-3"></td>
        </tr>
        <tr>
          <td><label>Gender: </label></td>
          <td><input type="radio" name="gender" checked<?php if (isset($gender) && $gender == "female") echo "checked"; ?> value="female">Female
            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "male") echo "checked"; ?>   value="male">Male
            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "other")  echo "checked"; ?> value="other">Other
          </td>
        </tr>
        <tr>
          <td><label> Country: </label></td>
          <td>
          <select name="country" id="country" class="form-select" required>
            <?php echo $countryOptions;?>
          </select>
          </td>
        </tr>


        <tr>
          <td><label> State: </label></td>
          <td>
          <select name="state" id="state" class="form-select"  required>
            <option>Select State</option>
          </select>
          </td>
        </tr>
        <tr>
          <td><label> City: </label></td>
          <td>
          <select name="city" id="city" class="form-select">
            <option>Select City</option>
          </select>
          </td>
        </tr>
        <tr>
          <td><label>Bio: </label></td>
          <td><textarea name="bio" class="form-control mb-3"></textarea></td>

        </tr>
        <tr>
          <td><label> Profile : </label></td>
          <td><input id="profile" type="file" name="profile" placeholder="Photo" class="form-control mb-3" ></td>
        </tr>
        <tr>

          <td><label> Active Social Media : </label></td>
          <td><input type="checkbox" class="form-check-input" id="check1" name="social_media[]" value="Instagram">
            <label class="form-check-label" for="check1">Instagram</label>
          </td>

        </tr>
        <tr>
          <td></td>
          <td>
        <tr>
          <td></td>
          <td><input type="checkbox" class="form-check-input" id="check2" name="social_media[]" value="twitter">
            <label class="form-check-label" for="check2">twitter</label>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check3" name="social_media[]" value="LinkedIN">
              <label class="form-check-label" for="check2">LinkedIN</label>
            </div>
          </td>
        <tr>
          <td></td>
          <td>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check4" name="social_media[]" value="facebook">
              <label class="form-check-label" for="check2">facebook</label>
            </div>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="check5" name="social_media[]" value="whatsapp">
              <label class="form-check-label" for="check2">whatsapp</label>
          </td>
        </tr>
        </table>
  </div>
        <tr>
          <td>
          
            <div class="col mb-2">
              <center><input type="submit" class="btn btn-primary btn-block mb-4" name="submit" value="Submit" ></center>
              
              <center><input type="button" class="btn btn-primary btn-block mb-4" value="Users List"
                onClick="document.location.href='viewform.php'" /></center>

          </td></div>

  </tr>

 
  </form>
</body>

</html>