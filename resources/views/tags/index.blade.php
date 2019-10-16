@extends('layouts.app', ['title' => __('Tags')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <h3 class="mb-0">{{ __('Tags') }}</h3>
                            </div>
                            <div class="col-md-6">
                              <tag-search-component />
                            </div>
                            <div class="col-md-3 text-right">
                                <a href="{{ route('tag.create') }}" class="btn btn-sm btn-primary">{{ __('Add Tag') }}</a>
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
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tags as $tag)
                                    <tr class="{{ $tag->trashed() ? 'bg-danger' : ''}}">
                                        <td>{{ $tag->name }}</td>
                                        <td>{{ $tag->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-right">
                                          <div class="dropdown">
                                              <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <i class="fas fa-ellipsis-v"></i>
                                              </a>
                                              <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <form action="{{ route('tag.destroy', $tag) }}" method="post">
                                                  @csrf
                                                  @method('delete')
                                                  @if ($tag->trashed())
                                                    <a class="dropdown-item" href="{{ route('tag.restore', $tag) }}">{{ __('Restore') }}</a>
                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to force delete this tag?") }}') ? this.parentElement.submit() : ''">
                                                        {{ __('Force Delete') }}
                                                    </button>
                                                  @else
                                                    <a class="dropdown-item" href="{{ route('tag.edit', $tag) }}">{{ __('Edit') }}</a>
                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this tag?") }}') ? this.parentElement.submit() : ''">
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
                            {{ $tags->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
