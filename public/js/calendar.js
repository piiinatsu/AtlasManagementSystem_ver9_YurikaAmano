$(function(){
  $(document).on('click', '.cancel-btn', function () {
    const reserve = $(this).data('reserve');
    const date    = $(this).data('date');
    const time    = $(this).data('time');

    $('#modalDate').text(date);
    $('#modalTime').text(time);
    $('#confirmCancel').data('reserve', reserve);

    $('.js-cancel-modal').fadeIn();
  });

  // モーダルを閉じる
  $(document).on('click', '.js-cancel-close', function (e) {
    e.preventDefault();
    $('.js-cancel-modal').fadeOut();
  });

  // 「キャンセル」確定 → 既存の #deleteParts にPOST
  $('#confirmCancel').on('click', function () {
    const reserve = $(this).data('reserve');
    if (!reserve) return;

    const $form = $('#deleteParts');
    $form.find('input[name="delete_date"]').remove();
    $('<input>', { type:'hidden', name:'delete_date', value: reserve }).appendTo($form);

    // 閉じてから送信
    $('.js-cancel-modal').fadeOut(function(){ $form.trigger('submit'); });
  });
});
