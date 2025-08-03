<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories(){
        // リレーションの定義
        return $this->hasOneThrough(
            \App\Models\Categories\SubCategory::class, // 最終的にたどり着きたいモデル（サブカテゴリ）
            \App\Models\Posts\PostSubCategory::class,  // 間にある中間テーブルのモデル
            'post_id',        // 中間テーブルにある「投稿のID」
            'id',             // サブカテゴリテーブルの主キー
            'id',             // 投稿テーブルの主キー
            'sub_category_id' // 中間テーブルにある「サブカテゴリID」
        );
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }

    // いいね数
    public function likes()
    {
        return $this->hasMany(\App\Models\Posts\Like::class, 'like_post_id');
    }

}