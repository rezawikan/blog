<?php

namespace App\Http\View\Composers;

use App\Models\PostCategory;
use Illuminate\View\View;

class CategoryParentComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $categories;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(PostCategory $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('parents', $this->categories->parents()->whereNull('deleted_at')->orderBy('name','desc')->get());
    }
}
