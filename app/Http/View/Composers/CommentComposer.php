<?php

namespace App\Http\View\Composers;

use App\Models\Comment;
use Illuminate\View\View;

class CommentComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $comments;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(Comment $comments)
    {
        $this->comments = $comments;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('comments', $this->comments->whereNull('deleted_at')->orderBy('body','desc')->get());
    }
}
