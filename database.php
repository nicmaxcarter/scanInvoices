
<?php
// used to connect to the database
$host = "conichost.com";
$db_name = "conich6_linehaul_consulting";
$username = "conich6_linehaul_admin";
$password = "FedEx2310@#!";
  
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}
  
// show error
catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}
?>