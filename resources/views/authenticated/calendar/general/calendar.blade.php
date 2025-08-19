<x-sidebar>
<div class="min-vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <p class="text-center">{{ $calendar->getTitle() }}</p>
    <div class="w-75 m-auto border border-top-0" style="border-radius:5px;">
      {!! $calendar->render() !!}
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
<!-- キャンセル確認モーダル -->
<div class="modal js-cancel-modal">
  <div class="modal__bg js-cancel-close"></div>
  <div class="modal__content">
    <div class="w-100">
      <div class="w-50 m-auto">
        <div>予約日：<span id="modalDate"></span></div>
        <div>時間：<span id="modalTime"></span></div>
        <p>上記の予約をキャンセルしてもよろしいでしょうか？</p>
      </div>
      <div class="w-50 m-auto d-flex justify-content-between mt-3">
        <a href="#" class="btn btn-primary js-cancel-close">閉じる</a>
        <button type="button" class="btn btn-danger" id="confirmCancel">キャンセル</button>
      </div>
    </div>
  </div>
</div>

</x-sidebar>
