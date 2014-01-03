$(function(){

  var $window = $(window),
      $fullh = $('.fullh'),
      $navitem = $('nav li');
      $btns = $('.btnbox button');

  // With throttle
  $window.resize($.throttle(20, function(){
      var $window = $(window),
          $wh = $window.height()
      $fullh.css('minHeight', $wh);
  })).resize();

  // Copy to clipboard
  var copied = '<p class="copied">✓ Copied</p>';
  $('.copy').click(function(){
    copyToClipboard('Ƀ');
  })
  function copyToClipboard (text) {
    window.prompt ("Copy to clipboard: Ctrl+C, Enter", text);
    $('.theb').parent('h1').prepend(copied);
  }

  // zclip (Flash)
  function doZclip(){
    $('.theb').zclip({
      path:'js/ZeroClipboard.swf',
      copy:$('.theb').text(),
      afterCopy:function(){
        $(this).parent('h1').prepend(copied);
      }
    })
  }
  doZclip();

  // Smoooth crolling
  $(function() {
    $('a[href*=#]:not([href=#])').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          $('html,body').animate({
            scrollTop: target.offset().top
          }, 300);
          return false;
        }
      }
    });
  });
  
  // Header minimizing
  $(window).scroll( function() {
    var value = $(this).scrollTop();
    if ( value > $window.height()-1 ){
      $(".min").addClass('visible');
    }else{
      $(".min").removeClass('visible');
    }
  });
  $(window).scroll();
    
  // Popup
  $(document).ready(function() {
    $('.zoom').magnificPopup({type:'image'});
  });

});



