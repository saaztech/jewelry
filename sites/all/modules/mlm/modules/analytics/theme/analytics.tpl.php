<?php
 
 $path = drupal_get_path('module', 'mlm');
  drupal_add_js($path . '/js/chart_load.js');
  
 $session_data = array();
 $page_data = array();
 $periods = 30;
 $interval = 'day';
 
 $rows = $analytics->getRows();
 if ( !is_array($rows) ) $rows = array();
 $rows = array_reverse($rows);
 $row_index = 0;
 for ( $i = 0; $i < $periods; $i++ ) {
    $loopstamp = strtotime($i * -1 . ' ' . $interval);
    $loopinterval = (int)date("mj", $loopstamp);
    $loopdisplay = "Date(" . date("Y, ", $loopstamp) . (date("n", $loopstamp) - 1) . date(" , j", $loopstamp) . ")";
    if (array_key_exists($row_index, $rows)) {
      $session_count = $rows[$row_index][0];
      $pageview_count = $rows[$row_index][1];
      $pageviews_per_user = $session_count > 0 ? $pageview_count / $session_count : 0;
    } else { 
      $session_count = 0; 
      $pageview_count = 0;
      $pageviews_per_user = 0;
    }
    $session_data[$loopinterval] = array($loopdisplay, $session_count);
    //$session_data[$loopinterval] = array($loopdisplay, $session_count, $pageview_count, $pageviews_per_user);
    $page_data[$loopinterval] = array($loopdisplay, $pageview_count);
    $row_index++;
    unset($session_count);
    unset($pageview_count);
    unset($pageviews_per_user);
  }
  
  $session_data = array_values($session_data);
  $page_data = array_values($page_data);
//  $session_data[] = array(
//    array("type" => 'date', "label" => 'Date'), 
//    array("type" => "number", "label" => "Users"), 
//    array("type" => "number", "label" => "Pageviews"),
//      array("type" => "number", "label" => "Pages / User")
//  );
  $session_data[] = array(array("type" => 'date', "label" => 'Date'), array("type" => "number", "label" => "Sessions"));
  $page_data[] = array(array("type" => 'date', "label" => 'Date'), array("type" => "number", "label" => "Pageviews"));
  $session_data = array_reverse($session_data);
  $page_data = array_reverse($page_data);
  
  

 
?>
<div class="row">
  <div class="col-md-6">
    <h3>Page Views</h3>
    <div class="representative-analytics well info" id="RepresentativePageAnalytics"></div>
  </div>
  <div class="col-md-6">
    <h3>Sessions</h3>
    <div class="representative-analytics well info" id="RepresentativeSessionAnalytics"></div>
  </div>
</div>

<script>
  //google.charts.load('current', {packages: ['corechart', 'line']});
  google.charts.setOnLoadCallback(function () {
    var data = new google.visualization.arrayToDataTable(<?php echo drupal_json_encode($session_data); ?>);
    var options = {hAxis: {title: ''}, vAxis: {title: ''}, chartArea: {  width: "60%", height: "70%" }};
    var chart = new google.visualization.LineChart(document.getElementById('RepresentativeSessionAnalytics'));
    chart.draw(data, options);
    
    
    var data = new google.visualization.arrayToDataTable(<?php echo drupal_json_encode($page_data); ?>);
    var options = {hAxis: {title: ''}, vAxis: {title: 'Page Views'}};
    var chart = new google.visualization.LineChart(document.getElementById('RepresentativePageAnalytics'));
    chart.draw(data, options);

  });
</script>