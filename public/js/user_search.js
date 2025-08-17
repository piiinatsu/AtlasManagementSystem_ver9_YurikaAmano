$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
    $(this).find('.arrow i').toggleClass('fa-angle-down fa-angle-up');
  });

  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
    $(this).find('.arrow i').toggleClass('fa-angle-down fa-angle-up');
  });
});
