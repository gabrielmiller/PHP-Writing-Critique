<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <link rel="icon" href="favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Writing critiques" />
    <meta name="keywords" content="literature, nonfiction, writing, critiquing" />
    <title>Wordcrafting with Susan</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<ul id="loginbar">
<div class="headerset">
<h1>Wordcrafting with Susan</h1>
    <?php
    if($_SESSION['signed_in'])
    {
        echo '<li><a href="user.php">'.htmlentities($_SESSION['username']).'</a></li><li><a class="login"> href="signout.php">Sign out</a>';
    }
    else
    {
        echo '<li><a href="signin.php">Sign in</a></li><li><a href="signup.php">Create an account</a></li>';
    }
    ?>
</div>
</ul>
<ul id="navigation">
<div class="headerset">
    <?php
    if($_SESSION['signed_in'])
    {
        echo '<li><a href="post.php">Post</a></li>';
    }
    ?>
    <li><a href="index.php">Home</a></li>
    <li><a href="archive.php">Archive</a></li>
    <li><a href="about.php">About</a></li>
</div>
</ul>
</div>
<div id="wrapper">
<div id="content">
