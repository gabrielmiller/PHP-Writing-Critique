<?php
include 'inc.database.php';

$page .= "<h2>Sign out:</h2>";


if($_SESSION['signed_in'] == true)
{
    $_SESSION['signed_in'] = NULL;
    $_SESSION['user_name'] = NULL;
    $_SESSION['user_pk'] = NULL;

    header("Location:index.php");
    exit;
}
else
{
    $page .= 'You are not <a href="signin.php">signed in</a>.';
}
include 'header.php';
print $page;
include 'footer.php';
?>
