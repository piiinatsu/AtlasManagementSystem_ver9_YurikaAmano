<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Posts\PostSubCategory;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\CommentFormRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\SubCategoryRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments', 'subCategories')->withCount('likes')->get();
        // メインカテゴリごとに紐づいたサブカテゴリを取得する
        $categories = MainCategory::with('subCategories')->get();
        $like = new Like;
        $post_comment = new Post;
        // ①キーワード検索がある場合（タイトル・本文：部分一致、サブカテゴリ：完全一致）
        if(!empty($request->keyword)){
            $keyword = $request->keyword;
            $posts = Post::with('user', 'postComments', 'subCategories')
            ->withCount('likes')
            ->where(function ($query) use ($keyword) {
                $query->where('post_title', 'like', '%'.$keyword.'%') // タイトルに含まれるか
                    ->orWhere('post', 'like', '%'.$keyword.'%')     // 投稿本文に含まれるか
                    ->orWhereHas('subCategories', function($q) use ($keyword) {
                            $q->where('sub_category', $keyword);       // サブカテゴリ名が完全一致
                        });
            })->get();

        // ②サブカテゴリを押下した場合（完全一致）
        }else if($request->category_word){
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments', 'subCategories')
            ->withCount('likes')
            ->whereHas('subCategories', function($q) use ($sub_category) {
                $q->where('sub_category', $sub_category); // サブカテゴリが一致する投稿のみ
            })->get();

        // ③「いいねした投稿」を押下した場合（投稿IDが「いいね済み」の投稿だけ）
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments', 'subCategories')
            ->withCount('likes')
            ->whereIn('id', $likes)->get();

        // ④「自分の投稿」を押下した場合
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments', 'subCategories')
            ->withCount('likes')
            ->where('user_id', Auth::id())->get();
        }

        // 各投稿のコメント数を取得して繰り返す(ビューに表示させるため)
        foreach ($posts as $post) {
            $post->comment_count = $post->commentCounts($post->id)->count();
        }

        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    public function postCreate(PostFormRequest $request){
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        // 中間テーブルにサブカテゴリを保存
        PostSubCategory::create([
            'post_id' => $post->id,
            'sub_category_id' => $request->post_category_id,
        ]);
        return redirect()->route('post.show');
    }

    public function postEdit(PostFormRequest $request){
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    public function mainCategoryCreate(MainCategoryRequest $request){
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function subCategoryCreate(SubCategoryRequest $request){
        SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'sub_category' => $request->sub_category,
        ]);
        return redirect()->route('post.input');
    }

    public function commentCreate(CommentFormRequest $request){
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        $count = Like::where('like_post_id', $post_id)->count();

        return response()->json(['like_count' => $count]);
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        $count = Like::where('like_post_id', $post_id)->count();

        return response()->json(['like_count' => $count]);
    }
}
