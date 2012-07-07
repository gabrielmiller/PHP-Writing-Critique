<?php
include 'inc.database.php';

$page = "";

if ($_SESSION['signed_in'] == true)
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        if($_GET['success']==1)
        {
            $page .= "<h2>Your post was submitted. It will be reviewed and published at a later date.</h2>";
        }

        $page .= "  <h2>Post a new piece:</h2>
            <form id=\"post\" action=\"\" method=\"POST\">
            <br><textarea name=\"text\"></textarea><br>
            <center>
            <button type=\"submit\" name=\"send\" value=\"1\">Submit</button>
            <button type=\"reset\" value=\"reset\">Reset</button>
            </center>
            </form>";
    }
    elseif (isset($_POST['send']) && $_POST['send']==1)
            {
                $text = trim($_POST['text']);
                if(strlen($text)>8000)
                {
                    $page .= "<br>Your text is longer than 8000 characters. Please shorten it."; 
                }
                else
                {
                    if(strlen($text)<100)
                    {
                        $page .= "<br>Your text is shorter than 100 characters. Please enter more.";
                    }
                    else
                    {
                        $create_date = date('Y-m-d H:i:s');
                        $author = $_SESSION['user_pk'];
                        $query = "INSERT into posts(author, create_date, text)
                            VALUES(?, ?, ?)";

                        $connection = dbConnect();
                        $stmt = $connection->stmt_init();
                        $stmt = $connection->prepare($query);
                        $stmt->bind_param('iss', $author, $create_date, $text);
                        $stmt->execute();
                        header("Location:post.php?success=1");
                        exit;
                    }
                }
            }
    else
    {
        header("Location: index.php");
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
