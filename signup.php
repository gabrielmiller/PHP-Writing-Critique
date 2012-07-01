<?php
include 'header.php'; 
echo '<h2>Sign up now!</h2>';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
echo '<form id="signup" action="" method=POST>
    <p><label>Email:</label><input type="text" name="emailaddr" id="emailiaddr"></p>
    <p><label>Username:</label><input type="text" name="username" id="username"></p>
    <p><label>Password:</label><input type="password" name="password" id="password"></p>
    <p><label>Re-enter Password:</label><input type="password" name="password2" id="password2"></p>
    <button type="submit" value="send">Sign up!</button>
    </form>';
}
else
{
    $errors = array();

    if(isset($_POST['emailaddr']))
    {
        if(strlen($_POST['emailaddr'])<5)
        {
        $errors[] = 'That\'s not a valid email address. Enter at least 6 characters.';
        }
        elseif(strlen($_POST['emailaddr'])>80)
        {
        $errors[] = 'That\'s not a valid email address. Enter less than 80 characters.';
        }
        
    }
    else
    {
        $errors[] = 'The email field is empty. Please enter an email address.';
    }

    if(isset($_POST['username']))
    {
        if(!ctype_alnum($_POST['username']))
        {
        $errors[] = 'That\'s not a valid username. Only alphanumeric characters are allowed.';
        }
    }
    else
    {
        $errors[] = 'The username field is empty. Please enter a username.';
    }

    if(isset($_POST['password']) && isset($_POST['password2']))
    {
                if($_POST['password'] != $_POST['password2'])
                {
                $errors[] = 'Your passwords did not match.';
                }
    }
    else
    {
        $errors[] = 'Enter your password in both password fields.';
    }

    if((strlen($_POST['password'])<5) || (strlen($_POST['password2'])<5))
    {
            $errors[] = 'Your password must exceed 5 characters.';
    }

    if(!empty($errors))
    {
        if(count($errors)>1)
        {
            echo 'It looks you had some errors:<br><ul>';
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

        $salt = time();
        $formusername = trim($_POST['username']); 
        $formpassword = trim($_POST['password']);
        $formemail =    trim($_POST['emailaddr']);
        $passwd = sha1($formpassword . $salt);
        $sql = 'INSERT INTO users(username, email, pass, salt, create_date)
        VALUES(?, ?, ?, ?, ?)';

        include_once 'inc.database.php';
        //$conn = new mysqli('localhost', 'user', 'password', 'ex10') or die ('cannot open db');
        $conn = dbConnect();
        echo print_r($conn);
        $stmt = $conn->stmt_init();
        echo "so far so good..."; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssii', $formusername, $formemail, $passwd, $salt, $salt);
    
        $stmt->execute();
        if ($stmt->affected_rows == 1) 
        {
            echo "$formusername has been registered. You may now log in.";
        }
        elseif($stmt->errno == 1062)
        {
            echo "$formusername is already in use. Please choose another username.";
        }
        else
        {
            echo "There was a problem with the database.";
        }
        echo 'You\'re registered! Get ready for Susan to eviscerate your writing!!';
    }
}
include 'footer.php';
?>
