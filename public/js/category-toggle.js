$(function () {
  $('.main_categories').click(function(){
    $(this).children('ul').slideToggle();
    $(this).find('.arrow i').toggleClass('fa-angle-down fa-angle-up');
  });
});