<?php
include 'connection.php';

if (isset($_POST['country_id'])) {

  $stateOptions = '<option value="">Select State</option>';
  $query = "SELECT * FROM states where country_id={$_POST['country_id']}";
  $states = $conn->query($query);
  if ($states->num_rows > 0) {

    while ($state = $states->fetch_assoc()) {
      $stateOptions .= '<option value=' . $state['name'] . ' data-id=' . $state['id'] . '>' . $state['name'] . '</option>';
    }
  }
  echo $stateOptions;

} elseif (isset($_POST['state_id'])) {
  $cityOptions = '<option value="">Select City</option>';
  $query = "SELECT * FROM cities where state_id=" . $_POST['state_id'];
  $cities = $conn->query($query);
  if ($cities->num_rows > 0) {
    while ($city = $cities->fetch_assoc()) {
      $cityOptions .= '<option value=' . $city['name'] . ' data-id=' . $city['id'] . '>' . $city['name'] . '</option>';
    }
  }
  echo $cityOptions;

}


?>