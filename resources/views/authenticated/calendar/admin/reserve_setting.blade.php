<x-sidebar>
<div class="pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <p class="text-center">{{ $calendar->getTitle() }}</p>
    <div class="w-75 m-auto border border-top-0" style="border-radius:5px;">
      {!! $calendar->render() !!}
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
    </div>
  </div>
</div>
</x-sidebar>
