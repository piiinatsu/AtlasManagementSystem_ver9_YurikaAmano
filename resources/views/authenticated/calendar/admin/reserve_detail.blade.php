<x-sidebar>
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{ $date }}日</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="h-75 border">
      <table class="">
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>
        <tr class="text-center">
          <!-- 各予約枠のユーザーの人数を取り出して、全部足し算した結果を$totalに入れる -->
          @php
            $total = $reservePersons->sum(function ($setting) {
                          return $setting->users->count();
                      });
          @endphp

          @if($total === 0)
            <tr><td colspan="3" class="text-center text-muted">予約者はいません</td></tr>
          @else
            @foreach($reservePersons as $setting)
              @foreach($setting->users as $user)
                <tr class="text-center">
                  <td class="w-25">{{ $user->id }}</td>
                  <td class="w-25">{{ $user->over_name }} {{ $user->under_name }}</td>
                  <td class="w-25">リモート</td>
                </tr>
              @endforeach
            @endforeach
          @endif
          <!-- 各予約枠→各予約者 -->
        </tr>
      </table>
    </div>
  </div>
</div>
</x-sidebar>
