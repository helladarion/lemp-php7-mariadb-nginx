<?php
//Show errors
  error_reporting(E_ALL);
  ini_set('display_errors', 1);


try {
  $pdo = new PDO('mysql:host=localhost;dbname=db_captain', 'admin', 'pass');
  echo "Connected";
} catch (PDOException $e) {
  echo 'Error: ' . $e->getMessage();

}

// Run Query

$sql = 'SELECT * FROM Skin';
$stmt = $pdo->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch())
{
  echo $row['skin_color'];
}
?>

<?php
// $dbh = mysqli_connect('localhost', 'admin', 'pass');
// if (!$dbh) {
//     die('Could not connect: ' . mysqli_connect_error());
// }
// echo 'Connected successfully to MySQL database';
// mysqli_close($dbh);
?>

<?php
phpinfo();
?>
