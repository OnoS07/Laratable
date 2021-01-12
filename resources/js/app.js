/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

require('./components/Example');

$('.top-contents').hide().fadeIn(2000);

$(window).ready(function(){
  $('.recipe-contents .recipe-content').each(function(i){
    $(this).delay(i * 100).css({'visibility':'visible','opacity':'0'}).animate({'opacity': 1 },1000);
  });
});

$(window).ready(function(){
  $(".recipe-image", this).css("transform", "scale(1.0, 1.0)");
  $(".recipe-intro", this).css({"display": "none", "bottom": "0px"});
  });

$(window).ready(function(){
  $('.product-contents .product-content').each(function(i){
    $(this).delay(i * 50).css({'visibility':'visible','opacity':'0'}).animate({'opacity': 1 },1000);
  });
});

$(".recipe-select").hover(
  function(){
    $(".recipe-image", this).css({"transform": "scale(1.03, 1.03)", "transition-duration": "0.5s"});
    $(".recipe-intro", this).animate({bottom:"10px"}, 500).css("display", "block");
  },
  function(){
    $(".recipe-image", this).css("transform", "scale(1.0, 1.0)");
    $(".recipe-intro", this).css({"display": "none", "bottom": "0px"});
  });

$("#close-recipe").click(function(){
  $(".close-recipe-contents").slideToggle("slow");
});

$("#open-recipe").click(function(){
  $(".open-recipe-contents").slideToggle("slow");
});