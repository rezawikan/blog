<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CommentCreate extends FormRequest
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
          'body' => 'required',
          'parent_id' => 'nullable|exists:comments,id',
          'user_id' => 'required|exists:users,id',
          'post_id' => 'required|exists:posts,id'
        ];
    }
}
