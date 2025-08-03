<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSubCategory extends Model
{
    use HasFactory;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    // このモデルで保存できるカラム
    protected $fillable = [
        'post_id',
        'sub_category_id',
    ];

    // 投稿テーブルのみでは、どのサブカテゴリーが該当するのか分からない。
    // またサブカテゴリーテーブルのみでは、どの投稿が該当するのか分からない。
    // そのため、投稿とサブカテゴリーを結ぶ役割を持っている。

    // 投稿とのリレーション
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // サブカテゴリとのリレーション
    public function subCategory()
    {
        return $this->belongsTo(\App\Models\Categories\SubCategory::class);
    }
}
