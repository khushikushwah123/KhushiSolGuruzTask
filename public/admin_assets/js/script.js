jQuery(function($) {
        var path = window.location.href; 
        $('.nav-sidebar .nav-item .nav-link').each(function() {
          if (this.href === path) {
            $(this).addClass('active');
          }``
        });
      });
// ============================ //

