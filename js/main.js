$(function () {
  var $window = $(window),
      $thediv = $('.fullh')
    $window.resize(function() {
      $height = $window.height()
      $thediv.css('height', $height);
      $('nav li a').css('paddingTop', $height/15,5)
    }).resize();
  
  
  // Copy to clipboard
  var copied = '<p class="copied">✓ Copied</p>';
  $('.copy').click(function () {
    copyToClipboard('Ƀ');
  })


  // Scroll animation
  function scrolltop(time, href){
    $('html, body').animate({
      scrollTop: $(href).offset().top
    },time);
  }
  
  // Make page’s link scroll
  var pagelinks = $('#page a[href*=#]:not([href=#])');
  pagelinks.click(function(){
    var href = $(this).attr('href');
    scrolltop(200, href);
  })

  // zclip (Flash)
  function doZclip() {
    $('.copy').zclip({
      path: 'js/ZeroClipboard.swf',
      copy: $('.copy').text(),
      afterCopy: function () {
        $(this).parent('h1').prepend(copied);
      }
    })
  }
  doZclip();

  // Popup
  $(document).ready(function () {
    $('.zoom').magnificPopup({
      type: 'image',
      prependTo: '.popup'
    });
  });

  // Related to mmenu
  var $menu = $('#menu');

  // Toggle menu 
  $('.min .theb').click(function (e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    $menu.trigger($menu.hasClass('mm-opened') ? 'close.mm' : 'open.mm');
  });

  // Create the menu
  $menu.mmenu({
    position: 'right',
    onClick: {
      preventDefault: true,
      setSelected: false,
    }

  });

  // Click an anchor, scroll to section
  $menu.find('a').on('click',
    function () {
      var href = $(this).attr('href');
      if ($menu.hasClass('mm-opened')) {
        $menu
          .off('closed.mm')
          .one('closed.mm',
            function () {
              setTimeout(
                function () {
                  scrolltop(0, href)
                }, 10
              );
            }
        );
      } else {
        scrolltop(200, href)
      }
    }
  );
  
  // Cycle slideshow
  $( '.slide' ).cycle({
    easing:'linear',
    timeout:3000,
    speed:100
    //fx:'scrollHorz',
    //speed:8000
  });
  
});