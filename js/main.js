/*global $*/
function initMain() {

  // vh support is too uncommon
  (function resizeHeight() {
    var $window = $(window);
    var $thediv = $('.fullh');
    var $items = $('nav li a');
    $window.resize(function() {
      var height = $window.height();
      $thediv.css('height', height);
      $items.css('paddingTop', height/15);
    }).resize();
  }());

  // Copy to clipboard
  var copied = '<p class="copied">✓ Copied</p>';
  $('.copy').click(function() {
    copyToClipboard('Ƀ');
  });

  function copyToClipboard(text) {
    $('.theb').parent('h1').prepend(copied);
  }

  // Scroll animation
  function scrolltop(time, href) {
    $('html, body').animate({
      scrollTop: $(href).offset().top
    },time);
  }

  // Make page’s link scroll
  var pagelinks = $('#page a[href*=#]:not([href=#])');
  pagelinks.click(function() {
    var href = $(this).attr('href');
    scrolltop(200, href);
  });

  // zclip (Flash)
  function doZclip() {
    $('.copy').zclip({
      path: 'js/ZeroClipboard.swf',
      copy: $('.copy').text(),
      afterCopy: function() {
        $(this).parent('h1').prepend(copied);
      }
    });
  }
  doZclip();

  // Related to mmenu
  var $menu = $('#menu');

  // Toggle menu 
  $('.min .theb').click(function(e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    $menu.trigger($menu.hasClass('mm-opened') ? 'close.mm' : 'open.mm');
  });

  // Create the menu
  $menu.mmenu({
    position: 'right',
    onClick: {
      preventDefault: true,
      setSelected: false
    }
  });

  // Click an anchor, scroll to section
  $menu.find('a').on('click', function() {
    var href = $(this).attr('href');
    if (!$menu.hasClass('mm-opened')) {
      scrolltop(200, href);
      return;
    }
    $menu.off('closed.mm');
    $menu.one('closed.mm', function() {
      setTimeout(function() {
        scrolltop(0, href);
      }, 10);
    });
  });

  // Cycle slideshow
  $('.slide').cycle({
    easing: 'linear',
    timeout: 3000,
    speed: 100
    //fx: 'scrollHorz',
    //speed: 8000
  });
}
