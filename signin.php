<?php

include 'inc.database.php';

$page="";

$page .= '<h2>Sign in</h2>';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    header("Location:index.php");
    exit;
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        $page .= '<form method="post" action="">
                <p><label>Username:</label><input type="text" name="username" id="username"></p>
                <p><label>Password:</label><input type="password" name="password" id="password"></p>
                <center><button type="submit" value="send">Sign in</button></center>
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
                $page .= 'It looks like you had some errors:<br><ul>';
            }
            elseif(count($errors)==1)
            {
                $page .= 'It looks like you had an error:<br><ul>';
            }
            
            foreach($errors as $key => $value)
            {
                $page .= '<li>'.$value.'</li>';
            }
            $page .= '</ul>';
        }
        else
        {
            $query = 'SELECT pk, username, pass, salt
                      FROM users
                      WHERE username = "'.$_POST['username'].'"';
                
            $connection = dbConnect();
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $stmt->bind_result($user_pk, $username, $password, $salt);
            $stmt->fetch();
            if ($password == sha1($salt.$_POST['password']))
            {
                $_SESSION['signed_in']= true;
                $_SESSION['user_pk'] = $user_pk; 
                $_SESSION['username'] = $username; 
                header("Location: index.php");
                exit;
            }
            else
            {
                $page .= 'Your username/password combination did not match our records. Please try again.';
            } 
        }

    }
}


include 'header.php';
print $page;
include 'footer.php';
?>
