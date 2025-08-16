<x-sidebar>
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <!-- 投稿者名前 -->
      <p class="text-secondary"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <!-- 投稿タイトル -->
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}" class="text-dark font-weight-bold">{{ $post->post_title }}</a></p>
      <!-- サブカテゴリーとコメント数・いいね数の横並び -->
      <div class="d-flex justify-content-between align-items-center">
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
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
      <!-- 投稿ボタン -->
      <div class="mb-3">
        <a href="{{ route('post.input') }}" class="btn btn-cyan text-white py-2 btn-block">投稿</a>
      </div>
      <!-- キーワードの入力検索 -->
      <div class="input-group overflow-hidden mb-3 border">
        <input type="text"
              placeholder="キーワードを検索"
              name="keyword"
              form="postSearchRequest"
              class="form-control bg-transparent border-0 shadow-none">
        <div class="input-group-append">
          <input type="submit"
                value="検索"
                form="postSearchRequest"
                class="btn btn-cyan text-white rounded-0">
        </div>
      </div>

      <!-- ボタンを押下して検索する -->
      <div class="row no-gutters mb-3">
        <div class="col-6 pr-1">
          <input type="submit"
                name="like_posts"
                value="いいねした投稿"
                form="postSearchRequest"
                class="btn btn-pink text-white py-2 px-1 btn-block">
        </div>
        <div class="col-6 pl-1">
          <input type="submit"
                name="my_posts"
                value="自分の投稿"
                form="postSearchRequest"
                class="btn btn-amber text-white py-2 btn-block">
        </div>
      </div>

      <!-- カテゴリー検索 -->
      <ul class="list-unstyled m-0">
        @foreach($categories as $category)
          <li class="main_categories border-bottom text-muted" category_id="{{ $category->id }}" style="cursor:pointer;">
            <div class="d-flex justify-content-between align-items-center py-2">
              <span class="font-weight-bold">{{ $category->main_category }}</span>
              <span class="arrow"><i class="fas fa-angle-down"></i></span>
            </div>
            <ul class="list-unstyled w-100 mt-2">
              @foreach($category->subCategories as $sub_category)
                <li class="border-bottom py-2 ml-3 text-left">
                  <form action="{{ route('post.show') }}" method="GET" class="m-0" id="subCategoryForm{{ $sub_category->id }}">
                    <!-- hiddenのvalue→送信するデータの中身（画面には見えない） -->
                    <input type="hidden" name="category_word" value="{{ $sub_category->sub_category }}">
                    <!-- submitのvalue→ボタンに表示されるラベル文字 -->
                    <button type="submit" class="w-100 text-left btn text-muted p-0 m-0">
                      {{ $sub_category->sub_category }}
                    </button>
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
