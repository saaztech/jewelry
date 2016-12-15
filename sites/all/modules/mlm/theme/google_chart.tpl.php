<?php
  $path = drupal_get_path('module', 'mlm');
  drupal_add_js($path . '/js/chart_load.js');
  $html_class = implode(' ', $html_class);
?>
<div class="<?php echo $html_class; ?>">
  <div  id="<?php echo $html_id; ?>"></div>
</div>
<script>
  //google.charts.load('current', {packages: ['corechart', 'line']});
  google.charts.setOnLoadCallback(function () {
    var data = new google.visualization.arrayToDataTable(<?php echo drupal_json_encode($data); ?>);
    var options = <?php echo json_encode($options); ?>;
    var chart = new google.visualization.LineChart(document.getElementById('<?php echo $html_id; ?>'));
    chart.draw(data, options);
  });
</script>
