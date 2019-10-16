<?php

namespace App\Http\View\Composers;

use App\Models\Post;
use Illuminate\View\View;

class PostComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $posts;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(Post $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('posts', $this->posts->whereNull('deleted_at')->orderBy('title','desc')->get());
    }
}
