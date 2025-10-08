(function($) {
  'use strict';
  $(function() {
    // Use delegated event so it works with dynamically-rendered Vue components
    $(document).on('click', '[data-toggle="offcanvas"]', function() {
      $('.sidebar-offcanvas').toggleClass('active')
    });
  });
});