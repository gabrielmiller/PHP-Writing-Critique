<?php

//include 'inc.database.php';
include 'header.php';

echo '<h2>Sign in</h2>';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'You\'re already signed in.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        echo '<form method="post" action="">
                <p><label>Username:</label><input type="text" name="username" id="username"></p>
                <p><label>Password:</label><input type="password" name="password" id="password"></p>
                <button type="submit" value="send">Sign in</button>
                </form>';
    }
    else
    {
        $errors = array();
        echo 'what?';
        if(!isset($_POST['username']))
        {
            $errors = 'The username field is empty. Enter your username.';
        echo 'what2?'; 
        }
        
        if(!isset($_POST['password']))
        {
            $errors = 'The password field is empty. Enter your password.';
        echo 'what3?'; 
        }

        if(!empty($errors))
        {
            echo 'what4?';
            if(count($errors)>1)
            {
                echo 'It looks like you had some errors:<br><ul>';
            }
            elseif(count($errors)==1)
            {
                echo 'It looks like you had an error:<br><ul>';
            }
            else
            {
                echo 'what happened here?';
            }
            
            foreach($errors as $key => $value)
            {
                echo '<li>'.$value.'</li>';
            }
            echo '</ul>';
        }
        else
        {
            // run SQL query to sign in
            // check that the user exists with that password
            // otherwise do not sign in
            echo 'what5?';
        }

    }
}



include 'footer.php';
?>
