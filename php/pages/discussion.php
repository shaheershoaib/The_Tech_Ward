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


    $ds = "SELECT title, fullname, description FROM discussion, user WHERE discussion.email = user.email AND discussionId = '$discussionId'; ";
    $result = mysqli_query($connection, $ds);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo"<h1>".$row["title"]."</h1>";
        echo"<h3>By: ".$row["fullname"]."</h3>";
        echo "<h4>".$row["description"]."</h4>";

?>
        <h1>Comments</h1>
        <form method = "POST" action = "../create/create_comment.php">   
        <textarea name = "comment" placeholder = "What are your thoughts?"></textarea>
        <input name = "discussionId" type = "hidden" value = "<?php echo $discussionId ?>">
        <br>
        <button>Add Comment</button>
        </form>
        
    <?php
        $commentQuery = "SELECT fullname, body FROM user, comment WHERE user.email = comment.email AND comment.discussionId = '$discussionId'";
        $result = mysqli_query($connection, $commentQuery);

        while($row = $result->fetch_assoc())
        {
            echo"<p>By: {$row['fullname']} </p>";
            echo"<p>{$row['body']}</p>";
            echo "<br>";
        }

        // Support for comment

       
    ?>


        
        


<?php

    } else {
        // Discussion with provided ID does not exist
        echo "Discussion with ID $discussionId does not exist.";
    }
        
}



?>