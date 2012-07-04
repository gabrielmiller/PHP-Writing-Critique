<?php
include 'inc.database.php';
include 'header.php';
?>
<h2>Sign out:</h2>

<?php

if($_SESSION['signed_in'] == true)
{
    $_SESSION['signed_in'] = NULL;
    $_SESSION['user_name'] = NULL;
    $_SESSION['user_pk'] = NULL;

    header("Location:index.php?signed_out=1");
    echo 'You succesfully signed out.';
}
else
{
    echo 'You are not <a href="signin.php">signed in</a>.';
}

include 'footer.php';
?>
