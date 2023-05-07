<?php
// Start session
session_start();

// Connect to database
$conn = mysqli_connect('localhost', 'username', 'password', 'database');

// Get email and password from AJAX request
$email = $_POST['email'];
$password = $_POST['password'];

// Validate email and password
if (empty($email) || empty($password)) {
  $response = array('status' => 'error', 'message' => 'Please enter both email and password.');
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $response = array('status' => 'error', 'message' => 'Invalid email format.');
} else {
  // Check if email and password exist in database
  $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 0) {
    $response = array('status' => 'error', 'message' => 'Invalid email or password.');
  } else {
    // Generate confirmation code and send email
    $confirmation_code = rand(100000, 999999);
    // Send email using a third-party service like SendGrid or Mailchimp
    // Save confirmation code to database for validation later
    $query = "INSERT INTO confirmations (email, code) VALUES ('$email', '$confirmation_code')";
    mysqli_query($conn, $query);
    // Set session variables
    $_SESSION['email'] = $email;
    $_SESSION['confirmed'] = false;
    $response = array('status' => 'success');
  }
}

// Return response as JSON
echo json_encode($response);
?>
