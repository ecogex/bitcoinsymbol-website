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
//      $navitem.css({height : $wh/$navitem.length , paddingTop : Math.round($wh/15) });
//      $btns.css('height', Math.round($wh/6)-1);
//      $('header .bbox').css({ height :$wh/6*5 , paddingTop : Math.round($wh/9) });
  })).resize();

  // Copy to clipboard
  $('.copy').click(function(){
    copyToClipboard('Ƀ');
  })
  function copyToClipboard (text) {
    window.prompt ("Copy to clipboard: Ctrl+C, Enter", text);
  }


});


