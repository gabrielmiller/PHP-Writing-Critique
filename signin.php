<?php

include 'inc.database.php';
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
        if(strlen($_POST['username'])<5)
        {
            $errors[] = 'Your username must be at least 5 characters.';
        }
        
        if(strlen($_POST['password'])<5)
        {
            $errors[] = 'Your password must be at least 5 characters.';
        }

        if(!empty($errors))
        {
            if(count($errors)>1)
            {
                echo 'It looks like you had some errors:<br><ul>';
            }
            elseif(count($errors)==1)
            {
                echo 'It looks like you had an error:<br><ul>';
            }
            
            foreach($errors as $key => $value)
            {
                echo '<li>'.$value.'</li>';
            }
            echo '</ul>';
        }
        else
        {
        $query = 'SELECT username, pass, salt
                FROM users
                WHERE username = "'.$_POST['username'].'"';
                
        $connection = dbConnect();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $stmt->bind_result($username, $password, $salt);
        $stmt->fetch();
        //echo '$username = '.$username.'<br>$password = '.$password.'<br> $salt = '.$salt; 
        if ($password == sha1($salt.$_POST['password']))
            {
            $_SESSION['signed_in']= true;
            $_SESSION['username'] = $username; 
            echo "Welcome back $username"; 
            echo '<meta http-equiv="REFRESH" content="0;url=index.php">';
            }
            else
            {
            echo 'Your username/password combination did not match our records. Please try again.';
            } 
        }

    }
}



include 'footer.php';
?>
