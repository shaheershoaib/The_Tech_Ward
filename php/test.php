<!DOCTYPE html>
<html>

<p>Here are some results:</p>

<?php

$host = "cosc360.ok.ubc.ca";
$database = "db_11505328";
$user = "11505328";
$password = "11505328";



$connection = mysqli_connect($host, $user, $password, $database);


$error = mysqli_connect_error();
if($error != null)
{
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else
{
    //good connection, so do you thing
    $sql = "SELECT * FROM users;";

    $results = mysqli_query($connection, $sql);

    //and fetch requsults
    while ($row = mysqli_fetch_assoc($results))
    {
      echo $row['username']." ".$row['firstName']." ".$row['lastName']." ".$row['email']." ".$row['password']."<br/>";
    }

    mysqli_free_result($results);
    mysqli_close($connection);
}
?>
</html>
