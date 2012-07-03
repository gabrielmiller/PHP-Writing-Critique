<?php
include 'inc.database.php';
include 'header.php';

if($_SESSION['signed_in'] == true)
{
?>

<h2>User information:</h2>

<?php

if($_SESSION['user_pk'] != '001')
{
    $query = 'SELECT users.create_date AS user_date, published, posts.create_date, pub_date, text, response 
              FROM posts 
              INNER JOIN users ON posts.author = users.pk
              WHERE author = '.$_SESSION['user_pk'].'
              ORDER BY posts.create_date ASC';
   
    $connection = dbConnect();
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $stmt->bind_result($user_date, $pub_status, $date_create, $date_pub, $text_original, $text_response);
    $a = True;
    while ($stmt->fetch())
    {
        if ($a == TRUE)
        {
        echo 'You created your account, <em>'.$_SESSION['username'].'</em>, on '.date("F jS Y", strtotime($user_date)).'.<br><h2>Your posted entries:</h2>'; 
        }
        $a = NULL;
        echo '<div>Submitted '.date("F jS Y g:i A", strtotime($date_create)).'<br>';
        echo "<p>text: $text_original</p>";
        if ($pub_status==1)
        {
            echo "Published ".date("F jS Y g:i A", strtotime($date_pub))."<br>";
            echo "<p>response: $text_response </p>";
        }
        else
        {
            echo "Not yet published.";
        }
        echo "</div>";
    }

}
else
{

//if($_SERVER['REQUEST_METHOD'] != 'POST')
//{}
//else
//{}

    $query = 'SELECT users.username, posts.create_date, text, published, pub_date, response
              FROM posts 
              INNER JOIN users ON posts.author = users.pk
              ORDER BY posts.create_date ASC';

    $connection = dbConnect();
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $stmt->bind_result($sub_name, $createdate, $text_original, $pub_status, $date_pub, $text_response);
    while ($stmt->fetch())
    {
        echo "$sub_name submitted on ".date("F jS Y g:i A", strtotime($createdate)).":<br>";
        echo "<p>$text_original</p>";
        if ($pub_status==1)
        {
            echo "Published on ".date("F jS Y g:i A", strtotime($date_pub)).".";
            echo "Your response was: <br><p>$text_response</p>";
        }        
        else
        {
            echo "You haven't published this entry.";
        }
        echo "<hr>"; 
    }
}



//A SQL query will go here to show the published and unpublished entries you've posted. 
//If you are user '001' (Susan) you will be shown a dashboard to publish and unpublish posts
//and a box to write your critiques to entries.

}
else
{
    echo '<p>You are not <a href="signin.php">signed in</a>.</p>';
}

include 'footer.php';
?>
