<?php // />


/**
 * Rules integration access callback.
 */
function jc_custom_rules_access($type, $name) {
  if ($type == 'condition') {
    return TRUE;
  }
}


/* * *
 * Add conditions for comparing commerce option data
 * * */
function jc_custom_rules_condition_info() {
  $conditions = array();
	
  $conditions['jc_custom_compare_options'] = array(
    'label' => t('Compare Options'),
    'parameter' => array( // Currently takes line item as data type
      'commerce_line_item' => array(
        'type' => 'commerce_line_item',
        'label' => t('Line Item'),
        'description' => t('The line item containing the data in question.'),
      ),
      'option_field' => array( // Field that lists commerce options
        'type' => 'text',
        'label' => t('Option'),
        'options list' => 'jc_custom_field_options_list',
        'description' => t('The option associated with this order you want to compare.'),
        'restriction' => 'input',
      ),
      'operator' => array( // Operator // Currently only utilizes 'equals'
        'type' => 'text',
        'label' => t('Operator'),
        'description' => t('The comparison operator.'),
        'optional' => TRUE,
        'default value' => 'equals',
        'options list' => 'jc_custom_comparison_operator_options_list',
        'restriction' => 'input',
      ),
      'value' => array( // Value
        'type' => 'text',
        'label' => t('Value'),
        'description' => t('The value to compare against the address component. Bear in mind that addresses using select lists for various components may use a value different from the option you select. For example, countries are selected by name, but the value is the two letter abbreviation.'),
      ),
    ),
    'group' => t('Commerce Option'), // Put it in it's own group
    'callbacks' => array(
      'execute' => 'jc_custom_rules_compare_options', // Call this function to compare data and return boolean
    ),
  );
	
	return $conditions;
	
}


/* * *
 * Data comparison function
 * * *
 * Takes data provided as parameters as defined in jc_custom_rules_condition_info() above
 * * */
function jc_custom_rules_compare_options($lineitem, $field, $operator, $value) {
	
	list($bundle, $field_name) = explode('|',$field);
	
	$query = new EntityFieldQuery();
	
	$query
		->entityCondition('entity_type', 'commerce_option', '=')
		->propertyCondition('set_id', $bundle, '=')
		->propertyCondition('line_item_id', $lineitem->line_item_id, '=')
		->fieldCondition($field_name, 'value', $value, '=')
		->count(); // Make this a counting query only
	
	$result = $query->execute();
	
	if ($result > 0) {
		return TRUE;
	}
	
	return FALSE;
	
	
}



/* * *
 * List comparison operators
 * * */
function jc_custom_comparison_operator_options_list() {
  return array(
    'equals' => t('equals'),
  );
}

/* * *
 * List fields to be compared
 * * */
function jc_custom_field_options_list() {
	$bundles = field_info_bundles('commerce_option');
	
	foreach ($bundles as $name => $bundle) {
		$options = db_select('field_config_instance', 'i')
			->fields('i')
			->condition('entity_type', 'commerce_option', '=')
			->condition('bundle', $name, '=')
			->execute();
		
		foreach($options as $option) {
			$data = unserialize($option->data);
			$opts[$name][$name.'|'.$option->field_name] = $data['label'];
		}
		
	}
	
	return $opts;
}

