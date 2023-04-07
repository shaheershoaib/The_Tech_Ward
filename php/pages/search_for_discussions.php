
<style>
    .discussion{
        margin-top: 50px;
        display: flex;
        width: 100%;
        justify-content: flex-start;
        margin-left: 100px;
    }

    .edit-delete-buttons{
       position: absolute;
        margin-top: 50px;
    }

    .like-dislike-buttons{
        position: relative;
        right: 20px;
    }

    button:hover{
        cursor: pointer;
    }
</style>
<?php


use db\dbConnection;

session_start();


require_once '../db/dbConnection.php';
$dbConnection = new dbConnection();
$connection = $dbConnection->getConnection();
$error = $dbConnection->getError();

$search = $_GET["search"];
$orderby = $_GET["orderby"];




if($orderby == "Latest")
    $sql = "SELECT discussionId, title, fullname, user.email FROM discussion, user WHERE discussion.email = user.email AND title LIKE '$search%' ORDER BY discussionId DESC";
else $sql = "SELECT r.discussionId, r.title, r.fullname, r.email, s.rating
FROM (
    SELECT discussionId, title, fullname, user.email
    FROM discussion, user
    WHERE discussion.email = user.email AND title LIKE '$search%'
) AS r
LEFT OUTER JOIN (
    SELECT discussionId, SUM(isLike) as rating
    FROM discussionRating
    GROUP BY discussionId
) AS s ON r.discussionId = s.discussionId
ORDER BY s.rating DESC";


$result = mysqli_query($connection, $sql);
while ($row = $result->fetch_assoc()) {

    /**  Get likes of given discussion Id*/
    $discussionId = $row["discussionId"];
    $getLikeCount = "SELECT SUM(isLike) as likeCount FROM discussionRating WHERE discussionId = '$discussionId'";
    $likeCountResult = mysqli_query($connection, $getLikeCount);
    $likeCountResultRow = $likeCountResult->fetch_assoc();
    $totalRating = $likeCountResultRow["likeCount"];
    if($totalRating == null)
        $totalRating = 0;


    /**  Find if user liked or disliked particular discussion  */
    $email = $_SESSION["email"];
    $findIfDiscussionLikedOrDislikedByUser = "SELECT isLike FROM discussionRating WHERE discussionId = '$discussionId' AND email = '$email'";
    $isLikeResult = mysqli_query($connection, $findIfDiscussionLikedOrDislikedByUser);
    $isLikeResultRow = $isLikeResult->fetch_assoc();
    $isLike = $isLikeResultRow["isLike"];
    if($isLike == null)
        $isLike = 0;
    ?>


<div class = "discussion" discussionId = <?php echo $discussionId ?> >

    <?php if(!empty($_SESSION["email"])) { ?>

    <div class = "like-dislike-buttons" hasRated = <?php if($isLike != 0 ) echo "1"; else echo "0"; ?> >
    <button class = "likeButton" <?php if($isLike == 1) echo "disabled"; ?> > &#8593</button>
    <br>
        <p class = "totalRating"><?php echo $totalRating; ?></p>
    <button class = "dislikeButton"  <?php if($isLike == -1) echo "disabled"; ?> >&#x2193</button>
    </div>

    <?php } ?>
<?php
    echo "<a href = discussion.php?discussionId=".$discussionId."> <h2> <strong>".$row["title"]."</strong> </h2> <br> By:".$row["fullname"]."</a>";
    if($_SESSION["admin"] || $row["email"] == $_SESSION['email']) {
        ?>
    <div class = "edit-delete-buttons">
        <?php
        echo "<br>";
        echo "<a href='../create/delete_discussion.php?discussionId=" . $discussionId . "'><button>Delete</button></a>";
        echo "<a href='edit_my_discussion.php?discussionId=" . $discussionId . "'><button>Edit</button></a>";
        ?>
    </div>
        <?php
    }
    ?>
</div>
    <?php
}

?>


<script>




    $(".likeButton").on("click", function(){






        const discussionId =  $(this).parent().parent().attr("discussionId");
      const currentLikeCount =parseInt($(this).siblings(".totalRating").text());

        const hasRated = $(this).parent().attr("hasRated");

        var newLikeCount = 0;
        if(hasRated == "1")
            newLikeCount = currentLikeCount+2;
        else newLikeCount = currentLikeCount+1;

        $(this).siblings(".totalRating").text(newLikeCount);
        $(this).prop("disabled", true);
        $(this).parent().attr("hasRated", "1");
        $(this).siblings(".dislikeButton").prop("disabled", false);

       $.get("../create/update_discussion_rating.php", {discussionId: discussionId, isLike: 1}, function(){

       });


    });



    $(".dislikeButton").on("click", function(){




        const discussionId =  $(this).parent().parent().attr("discussionId");
        const currentLikeCount =parseInt($(this).siblings(".totalRating").text());
        const hasRated = $(this).parent().attr("hasRated");
        var newLikeCount = 0;
        if(hasRated == "1")
            newLikeCount = currentLikeCount-2;
        else newLikeCount = currentLikeCount-1;

        $(this).siblings(".totalRating").text(newLikeCount);
        $(this).prop("disabled", true);
        $(this).parent().attr("hasRated", "1");
        $(this).siblings(".likeButton").prop("disabled", false);

        $.get("../create/update_discussion_rating.php", {discussionId: discussionId, isLike: -1}, function(){

        });



    });

</script>


