<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' => ['required', 'string', 'max:10'],
            'over_name_kana' => ['required', 'string', 'regex:/^[ァ-ヶー　]+$/u', 'max:30'],
            'under_name_kana' => ['required', 'string', 'regex:/^[ァ-ヶー　]+$/u', 'max:30'],
            'mail_address' => ['required', 'string', 'email', 'max:100', 'unique:users,mail_address'],
            'sex' => ['required', 'in:1,2,3'],
            'old_year' => ['required', 'integer', 'min:2000'],
            'old_month' => ['required', 'regex:/^(0[1-9]|1[0-2])$/'],
            'old_day' => ['required', 'regex:/^(0[1-9]|[12][0-9]|3[01])$/'],
            'role' => ['required', 'in:1,2,3,4'],
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'over_name.required' => '姓は必須項目です。',
            'over_name.string' => '姓は文字列で入力してください。',
            'over_name.max' => '姓は10文字以下で入力してください。',

            'under_name.required' => '名は必須項目です。',
            'under_name.string' => '名は文字列で入力してください。',
            'under_name.max' => '名は10文字以下で入力してください。',

            'over_name_kana.required' => 'セイは必須項目です。',
            'over_name_kana.string' => 'セイは文字列で入力してください。',
            'over_name_kana.max' => 'セイは30文字以下で入力してください。',
            'over_name_kana.regex' => 'セイはカタカナで入力してください。',

            'under_name_kana.required' => 'メイは必須項目です。',
            'under_name_kana.string' => 'メイは文字列で入力してください。',
            'under_name_kana.max' => 'メイは30文字以下で入力してください。',
            'under_name_kana.regex' => 'メイはカタカナで入力してください。',

            'mail_address.required' => 'メールアドレスは必須項目です。',
            'mail_address.string' => 'メールアドレスは文字列で入力してください。',
            'mail_address.email' => '正しいメールアドレスの形式で入力してください。',
            'mail_address.max' => 'メールアドレスは100文字以下で入力してください。',
            'mail_address.unique' => 'このメールアドレスはすでに登録されています。',

            'sex.required' => '性別を選択してください。',
            'sex.in' => '性別の選択が正しくありません。',

            'old_year.required' => '生年月日の「年」を選択してください。',
            'old_year.min'      => '生年月日の年は2000年以降を選択してください。',
            'old_month.required' => '生年月日の「月」を選択してください。',
            'old_day.required' => '生年月日の「日」を選択してください。',

            'role.required' => '役職を選択してください。',
            'role.in' => '選択された役職が正しくありません。',

            'password.required' => 'パスワードは必須項目です。',
            'password.string' => 'パスワードは文字列で入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは30文字以下で入力してください。',
            'password.confirmed' => '確認用パスワードと一致しません。',
        ];
    }

}
