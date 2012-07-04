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
                
                if ($_GET['saved']==1)
                {
                    echo "<br><h2>Your changes were saved</h2><br>";
                }

                if ($_GET['warning']==1)
                {
                    echo "<br><h2>Warning: You published a blank response.</h2><br>";
                }

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
                        <form method=\"POST\" action=\"edit.php?article=$pk\">
                        <p><label>Author: $username</label></p>
                        <p><label>Date submitted: ".date("F jS Y g:i A", strtotime($date_create))."</label></p>
                        <p><label>Submitted text: </label>$text_original</p>";
                            if($pubstatus==1)
                            {
                            echo "
                        <p><label>Date published: ".date("F jS Y g:i A", strtotime($date_pub))."</label></p>";
                            }
                        echo "<p><label>Response text: </label><textarea name=\"response\">$text_response</textarea></p>
                        <p><label>Published?</label><input type=\"checkbox\" name=\"published\" ";
                            if($pubstatus==1){echo "checked";}
                echo"                                                                     ></p>
                        <button type=\"submit\" name=\"send\" value=\"1\">Save changes</button>
                        </form>
                        </div>";
            }
            elseif (isset($_POST['send']) && $_POST['send']==1)
            {
                $date_pub = date('Y-m-d H:i:s');
                //echo print_r($_POST);
                if($_POST['published']=='on')
                {
                    $published = 1;
                    if(strlen($_POST['response'])==0)
                    {
                        $warning=1;
                    }
                    else
                    {
                        $warning=0;
                    }
                }
                else
                {
                    $published = 0;
                }
                $response = $_POST['response'];
                $query = "  UPDATE posts
                            SET published = ?, response = ?, pub_date = ?
                            WHERE pk = ?";
                $connection = dbConnect();
                $stmt = $connection->stmt_init();
                $stmt = $connection->prepare($query);
                $stmt->bind_param('issi', $published, $response, $date_pub, $pk);
                $stmt->execute();
                //echo "<br><h2>Your changes are saved.</h2>";
                $url = "edit.php?article=$pk&warning=$warning&saved=1";
                header("Location: $url");
                
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
