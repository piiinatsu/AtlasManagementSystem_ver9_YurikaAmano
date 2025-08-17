<x-sidebar>
<div class="search_content w-100 border d-flex min-vh-100">
  <div class="reserve_users_area container-fluid py-3">
    <div class="row">
      @foreach($users as $user)
      <div class="col-12 col-sm-6 col-lg-3 mb-4 d-flex">
        <div class="one_person w-100 rounded shadow-sm p-3 h-100 bg-white border border-light">
          <div>
            <span>ID : </span><span class="font-weight-bold">{{ $user->id }}</span>
          </div>
          <div><span>名前 : </span>
            <a href="{{ route('user.profile', ['id' => $user->id]) }}" class="font-weight-bold text-primary">
              <span>{{ $user->over_name }}</span>
              <span>{{ $user->under_name }}</span>
            </a>
          </div>
          <div>
            <span>カナ : </span>
            <span class="font-weight-bold">({{ $user->over_name_kana }}</span>
            <span class="font-weight-bold">{{ $user->under_name_kana }})</span>
          </div>
          <div>
            @if($user->sex == 1)
            <span>性別 : </span><span class="font-weight-bold">男</span>
            @elseif($user->sex == 2)
            <span>性別 : </span><span class="font-weight-bold">女</span>
            @else
            <span>性別 : </span><span class="font-weight-bold">その他</span>
            @endif
          </div>
          <div>
            <span>生年月日 : </span><span class="font-weight-bold">{{ $user->birth_day }}</span>
          </div>
          <div>
            @if($user->role == 1)
            <span>役職 : </span><span class="font-weight-bold">教師(国語)</span>
            @elseif($user->role == 2)
            <span>役職 : </span><span class="font-weight-bold">教師(数学)</span>
            @elseif($user->role == 3)
            <span>役職 : </span><span class="font-weight-bold">講師(英語)</span>
            @else
            <span>役職 : </span><span class="font-weight-bold">生徒</span>
            @endif
          </div>
          <div>
            @if($user->role == 4)
              <span>選択科目 :</span>
              <span class="font-weight-bold">
                {{ $user->subjects->pluck('subject')->join('、') ?: '未登録' }}
              </span>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="search_area w-25 border">
    <div class="mt-3">
      <div>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div>
        <lavel>カテゴリ</lavel>
        <select form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div>
        <label>並び替え</label>
        <select name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="">
        <p class="m-0 search_conditions"><span>検索条件の追加</span></p>
        <div class="search_conditions_inner">
          <div>
            <label>性別</label>
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
          </div>
          <div>
            <label>権限</label>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label>選択科目</label>
            <span>国語</span>
            <input type="checkbox" name="subjects[]" value="1" form="userSearchRequest">
            <span>数学</span>
            <input type="checkbox" name="subjects[]" value="2" form="userSearchRequest">
            <span>英語</span>
            <input type="checkbox" name="subjects[]" value="3" form="userSearchRequest">
            <!-- このinputはid="userSearchRequest"のフォームに送るという意味 -->
          </div>
        </div>
      </div>
      <div>
        <input type="reset" value="リセット" form="userSearchRequest">
      </div>
      <div>
        <input type="submit" name="search_btn" value="検索" form="userSearchRequest">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
</x-sidebar>
