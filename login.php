<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_peluquería"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$email = $_POST['email'];
$pass = $_POST['contraseña'];


$sql = "SELECT * FROM login WHERE email = '$email' AND contraseña = '$pass'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
  header("Location: index.html");
  exit();
} else {
  echo "<h1>Invalid username or password</h1>";
}

$conn->close();
?>
