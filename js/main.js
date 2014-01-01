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
  $('.copy').click(function(){
    copyToClipboard('Ƀ');
  })
  function copyToClipboard (text) {
    window.prompt ("Copy to clipboard: Ctrl+C, Enter", text);
  }

  // zclip (Flash)
  $('.theb').zclip({
      path:'js/ZeroClipboard.swf',
      copy:$('.theb').text(),
      afterCopy:function(){
        $(this).parent('.h1').prepend(copied);
      }
    });
  });

  var copied = '<p class="copied">✓ Copied</p>';
  $(".theb").click(function(){
    $(this).parent('h1').prepend(copied);
  })
  
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
  
  // Popup
  $(document).ready(function() {
    $('.zoom').magnificPopup({type:'image'});
  });

});



