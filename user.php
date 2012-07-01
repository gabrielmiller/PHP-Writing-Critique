<?php
include 'inc.database.php';
include 'header.php';
?>

<?php
if($_SESSION['signed_in'] == true)
{
?>

<h2>User information:</h2>
<div style="height:240px"></div>

<?php

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
