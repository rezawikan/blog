@extends('layouts.app', ['title' => __('Posts')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <h3 class="mb-0">{{ __('Posts') }}</h3>
                            </div>
                            <div class="col-md-6">
                              <post-search-component />
                            </div>
                            <div class="col-md-3 text-right">
                                <a href="{{ route('post.create') }}" class="btn btn-sm btn-primary">{{ __('Add Post') }}</a>
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
                                    <th scope="col">{{ __('Image') }}</th>
                                    <th scope="col">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('Summary') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr class="{{ $post->trashed() ? 'bg-danger' : ''}}">
                                        <td>{{ $post->image }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->summary }}</td>
                                        <td>{{ $post->live ? 'live' : 'draft' }}</td>
                                        <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-right">
                                          <div class="dropdown">
                                              <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <i class="fas fa-ellipsis-v"></i>
                                              </a>
                                              <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <form action="{{ route('post.destroy', $post) }}" method="post">
                                                  @csrf
                                                  @method('delete')
                                                  @if ($post->trashed())
                                                    <a class="dropdown-item" href="{{ route('post.restore', $post) }}">{{ __('Restore') }}</a>
                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to force delete this Post?") }}') ? this.parentElement.submit() : ''">
                                                        {{ __('Force Delete') }}
                                                    </button>
                                                  @else
                                                    <a class="dropdown-item" href="{{ route('post.edit', $post) }}">{{ __('Edit') }}</a>
                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this Post?") }}') ? this.parentElement.submit() : ''">
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
                            {{ $posts->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
