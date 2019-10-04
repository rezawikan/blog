<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdate extends FormRequest
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
          'title'   => 'required',
          'body'    => 'required',
          'slug'    => 'required',
          'image'   => 'required',
          'summary' => 'required',
          'live'    => 'required',
          'user_id' => 'required|exists:users,id',
          'post_category_id' => 'required|exists:post_categories,id',
        ];
    }
}
