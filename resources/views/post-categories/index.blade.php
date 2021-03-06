@extends('layouts.app', ['title' => __('Post Categories')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <h3 class="mb-0">{{ __('Post Categories') }}</h3>
                            </div>
                            <div class="col-md-6">
                              <post-category-search-component />
                            </div>
                            <div class="col-md-3 text-right">
                                <a href="{{ route('post-category.create') }}" class="btn btn-sm btn-primary">{{ __('Add Post Category') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Parent') }}</th>
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($postCategories as $category)
                                    <tr class="{{ $category->trashed() ? 'bg-danger' : ''}}">
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->hasParent() ? $category->parent->name : 'NULL'  }}</td>
                                        <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-right">
                                          <div class="dropdown">
                                              <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <i class="fas fa-ellipsis-v"></i>
                                              </a>
                                              <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <form action="{{ route('post-category.destroy', $category) }}" method="post">
                                                  @csrf
                                                  @method('delete')
                                                  @if ($category->trashed())
                                                    <a class="dropdown-item" href="{{ route('post-category.restore', $category) }}">{{ __('Restore') }}</a>
                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to force delete this post category?") }}') ? this.parentElement.submit() : ''">
                                                        {{ __('Force Delete') }}
                                                    </button>
                                                  @else
                                                    <a class="dropdown-item" href="{{ route('post-category.edit', $category) }}">{{ __('Edit') }}</a>
                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this post category?") }}') ? this.parentElement.submit() : ''">
                                                        {{ __('Delete') }}
                                                    </button>
                                                  @endif
                                                </form>
                                              </div>
                                          </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $postCategories->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
