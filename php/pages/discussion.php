<?php

$host = "localhost";
$database = "project";
$user = "webuser";
$password = "P@ssw0rd";

// $host = "cosc360.ok.ubc.ca";
// $database = "db_11505328";
// $user = "11505328";
// $password = "11505328";
$connection = mysqli_connect($host, $user, $password, $database);
$error = mysqli_connect_error();
if($error != null){
  $output = "<p>Unable to connect to database!</p>";
  exit($output);
}
else{

    parse_str($_SERVER['QUERY_STRING'], $params);
    $discussionId = $params['discussionId'];


    $ds = "SELECT discussionId, title, email, description FROM discussion WHERE discussionId = '$discussionId';";
    $result = mysqli_query($connection, $ds);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo"<h1>".$row["title"]."</h1>";
        echo"<h3>By: ".$row["email"]."</h3>";
        echo "<h4>".$row["description"]."</h4>";

    } else {
        // Discussion with provided ID does not exist
        echo "Discussion with ID $discussionId does not exist.";
    }
        
}



?>