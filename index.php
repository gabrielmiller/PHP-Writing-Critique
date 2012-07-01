<?php
include 'inc.database.php';
include 'header.php';
?>
<h2>Most recent review:</h2>

<?php

$pub_date = '2012-07-01 08:30';
$author = 'blah';
$text_donor = 'blerghy blergh';
$text_response = 'blargha blargh';

$query = 'SELECT users.username, pub_date, text, response 
          FROM posts 
          INNER JOIN users ON posts.author = users.pk 
          WHERE published = 1
          ORDER BY pub_date DESC
          limit 1';
$connection = dbConnect();
$stmt = $connection->prepare($query);
$stmt->execute();
$stmt->bind_result($author, $pub_date, $text_donor, $text_response);
$stmt->fetch();

echo '<div id="leftblock">On '.date("F jS Y g:i A", strtotime($pub_date))." $author wrote:<p>".$text_donor.'</p></div>';

echo '<div id="rightblock">Susan retorted:'.'<p>'.$text_response.'</p></div>';

include 'footer.php';
?>
