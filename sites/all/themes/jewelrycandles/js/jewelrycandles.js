/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function ($) {
  $(document).ready(function() {
      
    var navbar = $('#navbar nav .navbar-nav:first-child');
    //navbar.find()
      
    $('html').click(function() {
      $('.collection-menu').collapse('hide');
    });  
    
    $('#collection-menus').click(function(event){
      event.stopPropagation();
    });
      
      
  });
}(jQuery));


(function ($) {
  Drupal.behaviors.jewelrycandles = {
    attach: function (context, settings) {
      // Code to be run on page load, and
      // on ajax load added here
      var minus = $('<a class="btn btn-primary minus-quantity" href="#" >-</a>');
      var plus = $('<a class="btn btn-primary plus-quantity" href="#" >+</a>');
      $('.form-item-quantity > input').before(minus);
      $('.form-item-quantity > input').after(plus);
      
      $('.minus-quantity').click(function() {
        var contain = $(this).parent();
        var input = contain.find('input');
        var value = parseInt(input.val());
        var new_value = Math.max(1, value - 1);
        input.val(new_value);
      });
      
      $('.plus-quantity').click(function() {
        var contain = $(this).parent();
        var input = contain.find('input');
        var value = parseInt(input.val());
        var new_value = Math.max(1, value + 1);
        input.val(new_value);
      });
      
    }
  };
}(jQuery));























