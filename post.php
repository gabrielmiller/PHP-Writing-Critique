<?php
include 'inc.database.php';
include 'header.php';

if ($_SESSION['signed_in'] == true)
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        if($_GET['success']==1)
        {
            echo "<h2>Your post was submitted.</h2>";
        }

        echo "  <h2>Post a new piece:</h2>
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
                    echo "<br>Your text is longer than 8000 characters. Please shorten it."; 
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
                }
            }
    else
    {
        header("Location: index.php");
    }
}
else
{
   echo '<p>You are not <a href="signin.php">signed in</a>.</p>';
}

include 'footer.php';
?>
