<?php
include 'inc.database.php';
include 'header.php';
?>
<h2>Archived posts:</h2>

<?php
$query = 'SELECT users.username, posts.create_date, pub_date, text, response 
          FROM posts 
          INNER JOIN users ON posts.author = users.pk 
          WHERE published = 1 
          ORDER BY pub_date DESC'; 
$connection = dbConnect();
$stmt = $connection->prepare($query);
$stmt->execute();
$stmt->bind_result($author, $create_date, $pub_date, $text_donor, $text_response);
while ($stmt->fetch())
{

echo '<div id="leftblock">On '.date("F jS Y g:i A", strtotime($create_date))." <em>$author</em> wrote:<p>".$text_donor.'</p></div>';

echo '<div id="rightblock">On '.date("F jS Y g:i A",strtotime($pub_date)).' <em>Susan</em> retorted:'.'<p>'.    $text_response.'</p></div><p></p>';
}

include 'footer.php';
?>
