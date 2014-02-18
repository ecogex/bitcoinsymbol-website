var el = $('.number'),
    time = 100;
function rotate1(){
  el.removeClass('r2');
  el.addClass('r1');
}
function rotate2(){
  el.removeClass('r1');
  el.addClass('r2');
}
function rotate3(){
  el.removeClass('r2');
}

var animate = true;

function animation(){
    console.log(animate)
  if (animate){
    setTimeout( rotate1, time);
    setTimeout( rotate2, time*2);
    setTimeout( rotate1, time*3);
    setTimeout( rotate2, time*4);
    setTimeout( rotate3, time*5);
  }
  setTimeout( animation, time*50);
}

animation()

$(document).keyup(function(e){
  checkfocus();
});
el.click(function(){
  checkfocus();
})

function checkfocus(){
  notzero = false;
  el.each(function(){
    var value = $(this).val();
    if (value !== '0' && value !== '' ){
      notzero = true;
    }
  })
  if(el.is(':focus') || notzero ) {
    animate = false;
  }else{
    animate = true;
  }
}
