<?php
include 'inc.database.php';

$page = "";


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
                    $page .= "<br><h2>Your changes were saved</h2><br>";
                }

                if ($_GET['warning']==1)
                {
                    $page .= "<br><h2>Warning: You published a blank response.</h2><br>";
                }

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

                $page .= "<div id=\"submissionEdit\">
                        <form method=\"POST\" action=\"edit.php?article=$pk\">
                        <p><label>Author: <em>$username</em></label></p>
                        <p><label>Date submitted: ".date("F jS Y g:i A", strtotime($date_create))."</label></p>
                        <p><label>Submitted text: </label></p><p id=\"submitted\">$text_original</p>";
                        if($pubstatus==1)
                        {
                            $page .= "
                            <p><label>Date published: ".date("F jS Y g:i A", strtotime($date_pub))."</label></p>";
                        }
                        $page .= "<p><label>Response text: </label></p><textarea name=\"response\">$text_response</textarea></br>
                        <p><label>Published?</label><input id=\"checkbox\" type=\"checkbox\" name=\"published\" ";
                            if($pubstatus==1){$page.="checked";}
                            $page.="></p>
                        <center><button type=\"submit\" name=\"send\" value=\"1\">Save changes</button></center>
                        </form>
                        </div>";
            }
            elseif (isset($_POST['send']) && $_POST['send']==1)
            {
                $date_pub = date('Y-m-d H:i:s');
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
                $url = "edit.php?article=$pk&warning=$warning&saved=1";
                header("Location: $url");
                exit;
                
            }
            else
            {
                header("Location: edit.php?article=$pk");
                exit;
            }
        }
        else
        {
            header('Location: user.php');
            exit;
        }
    }
    else
    {
        header('Location: user.php');   
        exit;
    }
}
else
{
    $page .= '<p>You are not <a href="signin.php">signed in</a>.</p>';
}

include 'header.php';
print $page;
include 'footer.php';
?>
