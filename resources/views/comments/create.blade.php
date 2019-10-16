@extends('layouts.app', ['title' => __('Comment')])

@section('content')
    @include('roles.partials.header', ['title' => __('Add Comment')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Comment') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('post-category.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('comment.store') }}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Comment information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Comment') }}</label>
                                    <textarea class="form-control form-control-alternative{{ $errors->has('body') ? ' is-invalid' : '' }}" rows="4" placeholder="{{ __('Reply') }}" name="body" required autofocus>{{ old('body') }}</textarea>
                                    @if ($errors->has('body'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('body') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                  <label class="form-control-label" for="input-name">{{ __('Post') }}</label>
                                  <select class="form-control" name="post_id" {{ request()->commentable_id ? 'readonly' : ''}}>
                                    @foreach ($posts as $key => $post)
                                      @if (request()->commentable_id == $post->id)
                                        <option value="{{ $post->id }}" selected>{{ $post->title }}</option>
                                      @else
                                        <option value="{{ $post->id }}">{{ $post->title }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </div>
                                @if (request()->commentable_id)
                                  <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Parent') }}</label>
                                    <select class="form-control" name="parent_id" {{ request()->commentable_id ? 'readonly' : ''}}>
                                      <option value="">{{ __('No Parent') }}</option>
                                      @foreach ($comments as $key => $comment)
                                        @if (request()->comment_id == $comment->id)
                                          <option value="{{ $comment->id }}" selected>{{ substr($comment->body,0,30) }} - {{ $comment->commentable->title }}</option>
                                        @else
                                          <option value="{{ $comment->id }}">{{ substr($comment->body,0,30) }} - {{ $comment->commentable->title }}</option>
                                        @endif
                                      @endforeach
                                    </select>
                                  </div>
                                @endif
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
