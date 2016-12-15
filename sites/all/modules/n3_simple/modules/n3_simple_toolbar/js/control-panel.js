(function ( $ ) {
   $(document).ready(function() {

    // Setup Color Swatches
   $('.n3-simple-toolbar-control-panel-collapse').click(collapse_control_panel);
	 

	function collapse_control_panel() {
		var control = $('#n3-simple-toolbar-control-panel');
		var left = control.css('left');
		var visible = false;
		var targetLeft = '0px';
		var bodyLeft = '200px';
		if ( left == '0px' ) {
			visible = true;
			targetLeft = '-200px';
			bodyLeft = '0px';
      $.cookie('Drupal.simpletoolbar.expanded', 0, {path: Drupal.settings.basePath, expires: 36500 });
		} else {
			$.cookie('Drupal.simpletoolbar.expanded', 1, {path: Drupal.settings.basePath, expires: 36500 });
		}
		
		
		$('#n3-simple-toolbar-control-panel').animate(
			{'left': targetLeft},
			500
		);
		
		$('body').animate(
			{'padding-left': bodyLeft},
			500
		);
		
		var icon = $('#toolbar').find('.toolbar-toggle').find('.fa');
		if ( visible ) {
			icon.removeClass('fa-caret-down');
			icon.addClass('fa-caret-right');
		} else {
			icon.removeClass('fa-caret-right');
			icon.addClass('fa-caret-down');
		}
		
	}
		 
  });
}( jQuery ));
