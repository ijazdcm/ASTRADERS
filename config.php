<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname="testemi";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


?>


<?php 

// $servername = "localhost";
// $username = "joyhoney_joyhoney";
// $password = "J83%ig{!Vw;j";
// $dbname="joyhoney_joyhoney";

// try {
//   $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
  

//   $sql="SET SESSION time_zone = '+5:30';";
//  $stmt=$conn->prepare($sql);
//  if( $stmt->execute())
//  {
//     //  echo"time seted";
//     //  echo "Connected successfully";
//  }
 
 
// } catch(PDOException $e) {
//   echo "Connection failed: " . $e->getMessage();
// }


?>