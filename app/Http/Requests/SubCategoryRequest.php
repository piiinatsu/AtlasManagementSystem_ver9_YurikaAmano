<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category' => 'required|string|max:100|unique:sub_categories,sub_category',
        ];
    }

    public function messages()
    {
        return [
            'main_category_id.required' => 'メインカテゴリーを選択してください。',
            'main_category_id.exists' => '選択されたメインカテゴリーが存在しません。',
            'sub_category.required' => 'サブカテゴリー名を入力してください。',
            'sub_category.string' => 'サブカテゴリー名は文字列で入力してください。',
            'sub_category.max' => 'サブカテゴリー名は100文字以内で入力してください。',
            'sub_category.unique' => 'そのサブカテゴリー名はすでに使われています。',
        ];
    }
}
