$(function () {
  // カテゴリー切り替え
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });

  // いいね
  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  // いいね解除
  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).addClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {

    });
  });

  // 編集モーダル
  $('.edit-modal-open').on('click',function(){
    $('.js-modal').fadeIn();
    var post_category_id = $(this).attr('post_category_id');
    var post_title = $(this).attr('post_title');
    var post_body = $(this).attr('post_body');
    var post_id = $(this).attr('post_id');
    $('select[name="post_category_id"]').val(post_category_id);
    $('.modal-inner-title input').val(post_title);
    $('.modal-inner-body textarea').text(post_body);
    $('.edit-modal-hidden').val(post_id);
    return false;
  });

  // 削除モーダル表示
  $('.delete-modal-open').on('click', function () {
    const postId = $(this).data('id');
    const deleteUrl = `/bulletin_board/delete/${postId}`;
    $('#deleteConfirmBtn').attr('href', deleteUrl); // URLをセット
    $('.js-delete-modal').fadeIn();
  });

  // 削除ボタンに confirm をつける
  $('#deleteConfirmBtn').on('click', function (e) {
    const confirmDelete = confirm('削除してよろしいですか？');
    if (!confirmDelete) {
      e.preventDefault(); // キャンセルされたらページ遷移させない
    }
  });


  // モーダルを閉じる
  $('.js-modal-close').on('click', function (e) {
    e.preventDefault(); // ← これがないと href="#" でリロードされる
    $('.js-modal, .js-delete-modal').fadeOut();
    return false;
  });

});
