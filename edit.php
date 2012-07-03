<?php
include 'inc.database.php';
include 'header.php';

$pk = $_GET['article'];

if ($_SESSION['signed_in'] == true)
{
    if($_SESSION['user_pk'] == 1) 
    {
        if($pk > 0)
        {
            if ($_SERVER['REQUEST_METHOD'] != 'POST')
            {
                //SQL query for entry author, publish status, create date, pub date, text, response
                $query = 'SELECT users.username, posts.create_date, text, published, pub_date, response 
                          FROM posts 
                          INNER JOIN users 
                          ON posts.author = users.pk 
                          WHERE posts.pk = '.$pk;
                
                $connection = dbConnect();
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $stmt->bind_result($username, $date_create, $text_original, $pubstatus, $date_pub, $text_response);
                $stmt->fetch();

                echo"   <div id=\"submissionEdit\">
                        <form method=\"POST\">
                        <p><label>Author: $username</label></p>
                        <p><label>Date submitted: ".date("F jS Y g:i A", strtotime($date_create))."</label></p>
                        <p><label>Submitted text: </label>$text_original</p>
                        <p><label>Date published: ".date("F jS Y g:i A", strtotime($date_pub))."</label></p>
                        <p><label>Response text: </label>$text_response</p>
                        <p><label>Published?</label><input type=\"checkbox\" value=\"1\" ";
                            if($pubstatus==1){echo "checked";}
                echo"                                                                     ></p>
                        <button type=\"submit\" value=\"send\">Save changes</button>
                        </form>
                        </div>";
            }
            else
            {
                header("Location: edit.php?article=$pk");
            }
        }
        else
        {
            header('Location: user.php');
        }
    }
    else
    {
        header('Location: user.php');   
    }
}
else
{
    echo '<p>You are not <a href="signin.php">signed in</a>.</p>';
}

include 'footer.php';
?>
