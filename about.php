<?php
include 'inc.database.php';
include 'header.php';
?>
<h2>About:</h2>
<p>Susan Miller is a prolific writer and the author of the bestsellers <em>To Kill a Flock of Birds</em> and <em>HOLY SHIT, YOUR WRITING SKILLS SUCK</em>.</p>
<div id="imagewrap"><img src="img/susan1.jpg"><br><em>Susan with her critically acclaimed books.</em></div>
<p>Throughout her life she's been fascinated with civil rights, environmental justice, and equity. She's a practicing Quaker and life-long civil rights supporter.</p>
<p>Susan graduated from Washington University and Wilmington College with studies in English and Sociology. She worked as an English teacher, stay-at-home-mother, school board president, substitute teacher, youth programs designer, librarian, and now in her retirement years she spends her time brutally critiquing writing. Over 20 years of correcting her childrens' writing errors have turned her into a text-correcting machine. Submit your own piece of writing and let Susan work with it-that is-if you want to feel like you were just pounded in the chest with a railway tie.</p>
<p>She is a major contributor to the quarterly newsletter <em>Freedom to Learn</em>.
<p>Susan resides in Sumneytown, Pennsylvania with her husband Jim, and their two cats.</p>
<p>Her daily schedule is as follows:</p>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">

      google.load('visualization', '1.0', {'packages':['corechart']});

      google.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Event');
        data.addColumn('number', 'Hours');
        data.addRows([ 
          ['Writing', 2],
          ['Reading', 1.5],
          ['Gardening', 1],
          ['Cooking', 1],
          ['Eating', 1],
          ['Watching television', 0.5],
          ['Playing with grand-daughters', 1],
          ['Fixing those darn whippersnappers\' terrible writing', 8],
          ['Sleeping', 8]
        ]);
        
        var options = {'title':'Susan\'s daily schedule',
        			   'width':960,
                       'height':360};

        var chart = new google.visualization.PieChart(document.getElementById('chart'));
        chart.draw(data, options);
      }
    </script>

<div id="chart"></div>
<p>This website is satirical, however many of the above-mentioned facts are actually true. The entries and responses were written by Gabe Miller(Susan's youngest son), friends, and perhaps some internet visitors. This website runs on a Linux, Apache, MySQL, and PHP stack and its construction was a PHP learning experience. I hope you enjoyed reading!

<?php
include 'footer.php';
?>
