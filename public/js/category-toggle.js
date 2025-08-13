$(function () {
  // メインカテゴリをクリックしたら発火
  $('.main_categories').on('click', function(){
    var $subMenu = $(this).children('ul').first();
    var $arrow = $(this).find('.arrow').first();

    // 開く前の状態をチェック
    var isOpen = $subMenu.is(':visible');

    // 矢印切り替え
    $arrow.html(isOpen ? '&#x2228;' : '&#x2227;');

    // スライド開閉
    $subMenu.slideToggle(200);
  });
});
