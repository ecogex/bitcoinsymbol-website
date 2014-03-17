/*global $*/
function initShop() {
  var el = $('.number');
  var time = 100;

  function rotate1() {
    el.removeClass('r2');
    el.addClass('r1');
  }

  function rotate2() {
    el.removeClass('r1');
    el.addClass('r2');
  }

  function rotate3() {
    el.removeClass('r2');
  }

  var animate = true;

  function animation() {
    if (animate) {
      setTimeout(rotate1, time);
      setTimeout(rotate2, time * 2);
      setTimeout(rotate1, time * 3);
      setTimeout(rotate2, time * 4);
      setTimeout(rotate3, time * 5);
    }
    setTimeout(animation, time * 50);
  }
  animation();

  $(document).keyup(checkfocus);
  el.click(checkfocus);

  function checkfocus() {
    var notzero = false;
    el.each(function() {
      var value = $(this).val();
      if (value !== '0' && value !== '') {
        notzero = true;
      }
    });
    animate = !(el.is(':focus') || notzero);
  }
  
  // Cycle slideshow
  $('.slide').cycle({
    easing: 'linear',
    timeout: 5000,
    pauseOnHover: true,
    speed: 100
  });
  
}

