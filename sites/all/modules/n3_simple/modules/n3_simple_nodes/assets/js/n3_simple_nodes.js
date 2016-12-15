jQuery(document).ready(function($) {
  // Automatically Update the Path when a user changes the Title
  $('.n3-simple-nodes-title').on('change keyup', n3_simple_nodes_update_url);
  $('.n3-simple-nodes-parent-item').on('change', n3_simple_nodes_update_url);
  
  function n3_simple_nodes_update_url() {
    var title = $('.n3-simple-nodes-title').val();
    var path = $('.n3-simple-nodes-url-path');
    var parent = $('.n3-simple-nodes-parent-item').val();
    
    // Clean this URL
    var url = title.replace(/[^a-zA-Z0-9 ]/g, '').replace(/[_ ]/g, '-').toLowerCase();
    if ( parent ) {
      url = parent + "/" + url;
    }
    
    // Update the Path
    path.val(url);
  }
  
});
