<?php 
  // Get the list of Taxonomy Specifications
  $fields = field_info_instances('taxonomy_term', 'specifications');
  $term_wrapper = entity_metadata_wrapper('taxonomy_term', $term);

  // Build the base table
  $table = array(
    'attributes' => array(
      'class' => array('specifications-table'),
    ),
    'header' => array(
      array('data' => 'Specifications', 'colspan' => 2, ),
    ),
    'rows' => array(),
  );
  
  // Process the fields!
  foreach($fields as $machine_name => $field) {
    $value = $term_wrapper->{$machine_name}->value();
    if ( !empty($value) ) {
      $table['rows'][] = array(
        array('data' => $field['label']),
        array('data' => $value, 'class' => array('text-right')),
      );
    }
  }
  
  // Generate and render the table.
  $table = theme('table', $table);
  print render($table);
?>

<div class="product-jewelry-notice">
  <?php 
    $description = check_markup($term->description, $term->format);
    print $description;
  ?>
</div>



