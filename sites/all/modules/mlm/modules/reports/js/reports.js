(function ($) {
console.log('test');
/**
 * Attaches the autocomplete behavior to all required fields.
 */
Drupal.behaviors.mlm_reports = {
  attach: function (context, settings) {
    
    
    $('.mlm-report-tab-button').click(function(e) {
      e.preventDefault();
      
      // Reset Buttons
      $('.mlm-report-tab-button').removeClass('active');
      $(this).addClass('active');
      
      // Hide all Tabs
      $('.mlm-report-tab').slideUp(0);
      
      // Determine the targeted tab.
      var tab = $(this).data('tab');
      
      // Show the correct tab.
      $('#' + tab).addClass('active').slideDown(1000);
      
    });
    
    
    // Reports Charts
    google.charts.load('current', {packages: ['corechart', 'line']});
    
    google.charts.setOnLoadCallback(function () {
      // Show the First Tab.
      $('.mlm-report-tab').hide(0);
      $('.mlm-report-tab.first').show(0);
    });
  }
};
})(jQuery);

