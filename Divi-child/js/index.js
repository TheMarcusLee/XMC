// Init fancyBox
$().fancybox({
  selector : '[data-fancybox="filter"]:visible',
  thumbs   : {
    autoStart : true
  }
});

// Show/hide selected links
$('#filter').on('change', function() {
  var $visible, val = this.value;
  
  if (val) {
    $visible = $('[data-fancybox="filter"]').hide().filter('.' + val);
    
  } else {
    $visible = $('[data-fancybox="filter"]');
  }
  
  $visible.show();
});