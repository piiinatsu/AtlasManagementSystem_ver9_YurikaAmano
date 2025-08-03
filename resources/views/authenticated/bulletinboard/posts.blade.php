<x-sidebar>
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <!-- 投稿者名前 -->
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <!-- 投稿タイトル -->
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <!-- 投稿のサブカテゴリー（初期投稿は登録していなかった） -->
      @if($post->subCategories)
        <button class="category_btn">{{ $post->subCategories->sub_category }}</button>
      @endif
      <!-- コメント数・いいね数 -->
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">{{ $post->comment_count }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0">
              <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
              <span class="like_counts{{ $post->id }}">{{ $post->likes_count }}</span>
            </p>
            @else
            <p class="m-0">
              <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
              <span class="like_counts{{ $post->id }}">{{ $post->likes_count }}</span>
            </p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
      <div class=""><a href="{{ route('post.input') }}">投稿</a></div>
      <!-- キーワードの入力検索 -->
      <div class="">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>
      <!-- ボタンを押下して検索する -->
      <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">
      <ul>
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}"><span>{{ $category->main_category }}</span>
          <ul>
            @foreach($category->subCategories as $sub_category)
              <li>
                <form action="{{ route('post.show') }}" method="GET" id="subCategoryForm{{ $sub_category->id }}">
                  <!-- hiddenのvalue→送信するデータの中身（画面には見えない） -->
                  <input type="hidden" name="category_word" value="{{ $sub_category->sub_category }}">
                  <!-- submitのvalue→ボタンに表示されるラベル文字 -->
                  <input type="submit" value="{{ $sub_category->sub_category }}" class="category_btn">
                </form>
              </li>
            @endforeach
          </ul>
        </li>
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
</x-sidebar>
