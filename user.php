<?php
include 'inc.database.php';

$page = "";

if($_SESSION['signed_in'] == true)
{

    if($_SESSION['user_pk'] != '001')
    {
        $page .= "<h2>User information:</h2>";
        $query = 'SELECT users.create_date AS user_date, published, posts.create_date, pub_date, text, response 
            FROM posts 
            INNER JOIN users ON posts.author = users.pk
            WHERE author = '.$_SESSION['user_pk'].'
            ORDER BY posts.create_date ASC';

        $connection = dbConnect();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $stmt->bind_result($user_date, $pub_status, $date_create, $date_pub, $text_original, $text_response);
        $a = True;
        while ($stmt->fetch())
        {
            if ($a == TRUE)
            {
                $page .= 'You created your account, <em>'.$_SESSION['username'].'</em>, on '.date("F jS Y", strtotime($user_date)).'.<br><h2>Your posted entries:</h2>'; 
            }
            $a = NULL;
            $page .= '<article class="submission">Submitted on '.date("F jS Y g:i A", strtotime($date_create)).'<br>';
            $page .= "<p>text: $text_original</p>";
            if ($pub_status==1)
            {
                $page .= "Published ".date("F jS Y g:i A", strtotime($date_pub))."<br>";
                $page .= "<p>response: $text_response </p>";
            }
            else
            {
                $page .= "Not yet published.";
            }
            $page .= "</article>";
        }
        if ($a == TRUE)
        {
            $page .= "You haven't submitted any posts. Get to it!";
        }

    }
    else
    {
        $page .= "<br>";
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            $query = 'SELECT posts.pk, users.username, posts.create_date, text, published, pub_date, response
                FROM posts 
                INNER JOIN users ON posts.author = users.pk
                ORDER BY posts.create_date ASC';

            $connection = dbConnect();
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $stmt->bind_result($post_pk, $sub_name, $createdate, $text_original, $pub_status, $date_pub, $text_response);
            while ($stmt->fetch())
            {
                $page .= "<article class=\"submission\">$sub_name submitted on ".date("F jS Y g:i A", strtotime($createdate)).":<br>";
                $page .= "<p><a class=\"submissionlink\" href=\"edit.php?article=$post_pk\">".substr($text_original,0,100)."...</a></p>";
                if ($pub_status==1)
                {
                    $page .= "Your response, published on ".date("F jS Y g:i A", strtotime($date_pub)).", ";
                    $page .= "was: <br><p><a class=\"submissionlink\" href=\"edit.php?article=$post_pk\">".substr($text_response,0,100)."...</a></p>";
                }        
                else
                {
                    $page .= "You haven't published this entry.";
                }

                $page .= "</article>"; 
            }
        }
        else
        {
            //This page doesn't receive any posts.
            header("Location: index.php"); 
            exit;
        }

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
