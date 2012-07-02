<?php
include 'inc.database.php';
include 'header.php';

if($_SESSION['signed_in'] == true)
{
?>

<h2>User information:</h2>

<?php

$query = 'SELECT published, create_date, pub_date, text, response 
          FROM posts 
          WHERE author = '.$_SESSION['user_pk'].'
          ORDER BY create_date DESC';

if($_SESSION['user_pk'] != '001')
{
    //echo 'You created your account on '.date("F jS Y g:i A", strtotime($account_date)); 
    
    $connection = dbConnect();
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $stmt->bind_result($pub_status, $date_create, $date_pub, $text_original, $text_response);

    while ($stmt->fetch())
    {
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
    echo 'you\'re Susan!';
    // create dashboard for all submissions and editing
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
