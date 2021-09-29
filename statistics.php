<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 

require_once "config.php";

$sql_pos = "SELECT count(*) FROM `patient` WHERE `pcr_results`='pos'";
$sql_neg = "SELECT count(*) FROM `patient` WHERE `pcr_results`='neg'";
$results_pos=0;
$results_neg=0;

$pos =mysqli_query($link, $sql_pos);
$neg =mysqli_query($link, $sql_neg);

while ($rowp = mysqli_fetch_row($pos) )  {
   
   $results_pos=$rowp[0];


}
 while ($rown = mysqli_fetch_row($neg)) {

    $results_neg=$rown[0];
 }








?>
















<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['PCR Test', 'Results'],
          ['Positive',   <?php echo $results_pos; ?>],
        
          ['Negative',     <?php echo $results_neg; ?>]
        ]);

        var options = {
          title: 'PCR Results ',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="donutchart" style="width: 900px; height: 500px;"></div>
  </body>
</html> 