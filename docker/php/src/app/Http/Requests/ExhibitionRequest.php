<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'img_url' => 'required|mimes:jpeg,png',
            'categories' => 'required',
            'condition' => 'required',
            'name' => 'required',
            'description' => 'required|max:255',
            'price' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'img_url.required' => '商品の画像を入力してください',
            'img_url.mimes' => '拡張子がjpegもしくはpngの画像を選択してください',
            'categories.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品についての説明を入力してください',
            'description.max' => '商品についての説明は255文字以内で入力してください',
            'price.required' => '商品の値段を入力してください',
            'price.integer' => '商品の値段は数値型で入力してください',
            'price.min' => '商品の値段は1円以上で入力してください',
        ];
    }
}
