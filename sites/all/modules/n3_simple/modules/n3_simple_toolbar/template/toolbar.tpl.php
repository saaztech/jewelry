<?php
	$css = drupal_get_path('module', 'n3_simple_toolbar') . '/css/toolbar.css';
	drupal_add_css($css);
	global $base_root;
?>
<div id="toolbar" class="<?php print $classes; ?> clearfix">
  <div class="toolbar-menu clearfix">
		<?php //print '<ul id="toolbar-home"><li class="first"><a href="#"><i class="fa fa-drupal"></i></a></li></ul>'; ?>
		<?php 
		$caret = path_is_admin(current_path()) ? 'down' : 'right';
		print '<ul class="toolbar-toggle"><li class="first"><a href="#" class="n3-simple-toolbar-control-panel-collapse">
		Toggle Menu <i class="fa fa-caret-' . $caret . '"></i></a></li></ul>';
		$site_name = variable_get('site_name', "Default site name"); 

		if ( path_is_admin(current_path()) ) {
		printf('<ul id="toolbar-home"><li class="first"><a href="/"><i class="fa fa-home"></i> %s</a>
			<ul class="sub"><li>' . l('Visit Site', '/') . '</li></ul>
			</li>
		</ul>', $site_name);
	} else { ?>
		
		<?php printf('<ul class="toolbar-dash"><li class="first"><a href="#">
					<i class="fa fa-tachometer"></i> %s</a>', $site_name); ?>
				
				<ul class="sub">
					<?php printf('<li><a href="%s/admin/dashboard">Dashboard</a></li>', $base_root); ?>
					<?php printf('<li><a href="%s/admin/appearance">Themes</a></li>', $base_root); ?>
					<?php printf('<li><a href="%s/admin/structure/block">Blocks</a></li>', $base_root); ?>
					<?php printf('<li><a href="%s/admin/structure/menu">Menus</a></li>', $base_root); ?>
				</ul>
			</li>
		</ul>
		
		<?php } ?>
		
		
		<ul id="toolbar-new">
			<li class="first">
				<a href="/"><i class="fa fa-plus"></i> New</a>
				<ul class="sub">
          <?php
            $node_types = n3_simple_node_types();
            foreach ( $node_types as $machine_name => $title ) {
              $node_title = ucwords($title);
              echo '<li>' . l($node_title, 'node/add/' . $machine_name) . '</li>';
            }
          ?>
          
          <!-- Still Needs Modifications -->
					<?php printf('<li><a href="%s/file/add">Media File</a></li>', $base_root); ?>
					<?php printf('<li><a href="%s/admin/people/create">User</a></li>', $base_root); ?>
				</ul>
			</li>
		</ul>
		
		
		
		

    <?php print render($toolbar['toolbar_user']); ?>
    <?php //print render($toolbar['toolbar_menu']); ?>
    <?php if ($toolbar['toolbar_drawer']):?>
      <?php print render($toolbar['toolbar_toggle']); ?>
    <?php endif; ?>
  </div>

  <div class="<?php echo $toolbar['toolbar_drawer_classes']; ?>">
    <?php print render($toolbar['toolbar_drawer']); ?>
  </div>
</div>

<div id="n3-simple-toolbar-control-panel">
	<?php 
				//$menu = menu_navigation_links('menu-simple-admin');
				//print theme('links__menu_simple_admin', array('links' => $menu));
				//$menu_tree_all_data = menu_tree_all_data('menu-simple-admin');
				//$menu_tree_output = menu_tree_output($menu_tree_all_data);
				//echo drupal_render($menu_tree_output);
				$links = n3_simple_toolbar_links();
				echo theme('n3_simple_toolbar_sidelinks', array('links' => $links));
		?>
	<hr />
	<ul class="menu clearfix"><li class="first leaf collapse-menu"><a href="#" class="n3-simple-toolbar-control-panel-collapse" title="">Collapse Menu</a></li>
</div>
