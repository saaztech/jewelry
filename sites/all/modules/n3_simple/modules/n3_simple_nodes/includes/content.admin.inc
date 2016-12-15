<?php

/**
 * Builds the Content Replacement Page (admin/content)
 * @return string Html Output.
 */
function n3_simple_nodes_content() {
  return 'cheese';
}

function n3_simple_content_type($form, &$form_state, $type, $tag = 0) {
	global $base_root;
	
	// Create Table Outline
	 $table = array(
      'caption' => ' ',
      'colgroups' => array(),
      'attributes' => array(
        'class' => array(
          'admin-simple-table',
          'table',
          'table-striped',
        ),
      ),
      'sticky' => false,
      'empty' => 'No results',
      'header' => array(
				'title' => array('data' => 'Title', 'field' => 'title'),
				'author' => array('data' => 'Author', 'field' => 'name'),
				'tags' => array('data' => 'Tags'),
				'status' => array('data' => 'Status', 'field' => 'status'),
				'date' => array('data' => 'Date', 'field' => 'changed'),
			),
      'rows' => array(),
    );
	
	// Primary Node Query
	$query = db_select('node', 'n')
		->fields('n', array('nid', 'title', 'changed', 'status'))
		->condition('n.type', $type, '=');
	 
	// Author
	$query->addJoin('LEFT OUTER', 'users', 'u', "n.uid = u.uid");
	$query->fields('u', array('uid', 'name'));
	
	// Tags
	$tags_query = db_select('field_data_field_tags', 'field_tags')
		->fields('field_tags', array('entity_id', 'entity_type'));
	$tags_query->addJoin('LEFT OUTER', 'taxonomy_term_data', 'cats', "cats.tid = field_tags.field_tags_tid");
	$tags_query->groupBy('field_tags.entity_id');
	$tagExpression = sprintf("GROUP_CONCAT(DISTINCT CONCAT('<a href=\"%s/admin/simple/%s/tag/', cats.tid, '\">', cats.name, '</a>' ) ORDER BY cats.tid ASC SEPARATOR ', ')", $base_root, $type);
	$tags_query->addExpression($tagExpression, 'terms');
	$query->addJoin('LEFT OUTER', $tags_query, 'field_tags', "field_tags.entity_id = n.nid AND field_tags.entity_type = 'node'");
	$query->fields('field_tags', array('terms'));

	// Pager
	$query = $query->extend('PagerDefault')->limit(50);
	
	// Sorter
	$query = $query->extend('TableSort')->orderByHeader($table['header']);
	
	// Execute the Query
	$results = $query->execute();
	
	// Loop over results
	while ( $row = $results->fetchAssoc() ) {
		
		// Load Variables
		$_title = $row['title'];
		$_date = $row['changed'];
		$_nid = $row['nid'];
		$_author = $row['name'];
		$_uid = $row['uid'];
		$_status = $row['status'];
		$_terms = $row['terms'];
		
		// Title
		$title = sprintf('<a href="%s/node/%d/edit?destination=admin/content/%s"><strong>%s</strong></a>
		<div class="item-links">
			<a href="%s/node/%d/edit?destination=admin/content/%s">Edit</a> | 
			<a class="delete-link" href="%s/node/%d/delete?destination=admin/content/%s">Delete</a> | 
			<a href="%s/node/%d">View</a>
		</div>
		', $base_root, $_nid, $type, $_title, $base_root, $_nid, $type, $base_root, $_nid, $type, $base_root, $_nid);
		
		// Date
		$date = date('Y/m/d', $_date);
		
		// Author
		$author = sprintf('<a href="%s/admin/simple/author/%d">%s</a>', $base_root, $_uid, $_author);
		
		// Status
		$status = $_status ? 'Published' : 'Not Published';
		
		// Terms
		$terms = empty($_terms) ? '--' : $_terms;
		
		// Terms
		$cats = empty($_cats) ? sprintf('<a href="%s/admin/simple/content/%s/tag/0">Uncategorized</a>', $base_root, $type) : $_cats;
		
		// Add the Row to the Table
		$table['rows'][$_nid] = array(
			'title' => array('data' => $title),
			'author' => array('data' => $author),
			'tags' => array('data' => $terms),
			'status' => array('data' => $status),
			'date' => array('data' => $date),
		);
	}
	
	
	
	// Build the Form
	$form = array(
		
		'actions_container' => array(
			'#type' => 'container',
			'#attributes' => array(
				'class' => array('inline-form-container', 'admin-table-filters'),
			),
			
			'actions' => array(
				'#type' => 'select',
				'#chosen' => true,
				'#empty_option' => 'Bulk Actions',
				'#options' => array(
					1 => 'Unpublish',
					2 => 'Publish',
					3 => 'Delete',
				),
			),
			
			'bulk_apply' => array(
				'#type' => 'submit',
				'#value' => 'Apply',
			),
			
			'dates' => array(
				'#type' => 'select',
				'#chosen' => true,
				'#options' => array(
					0 => 'All Dates',
					201501 => 'January 2015',
				),
			),
			
			'filter_apply' => array(
				'#type' => 'submit',
				'#value' => 'Filter',
			),
		),
		
		'nodes' => array(
			'#type' => 'tableselect',
			'#header' => $table['header'],
			'#options' => $table['rows'],
			'#empty' => 'No content available.',
			'#attributes' => array(
				'class' => array('admin-simple-table'),
			),
		),
	);
	
	// Return the form 
	return $form;
}