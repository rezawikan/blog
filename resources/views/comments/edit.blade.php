@extends('layouts.app', ['title' => __('Comment')])

@section('content')
    @include('permissions.partials.header', ['title' => __('Edit Comment')])

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
                                <a href="{{ route('comment.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('comment.update', $comment) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Comment information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Reply') }}</label>
                                    <textarea class="form-control form-control-alternative{{ $errors->has('body') ? ' is-invalid' : '' }}" rows="4" placeholder="{{ __('Reply') }}" name="body" required autofocus>{{ old('body', $comment->body) }}</textarea>
                                    @if ($errors->has('body'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('body') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                  <label class="form-control-label" for="input-name">{{ __('Approved') }}</label>
                                  <select class="form-control" name="approved">
                                    <option value="0" {{ $comment->approved == 1 ? 'selected' : '' }}>False</option>
                                    <option value="1" {{ $comment->approved == 1 ? 'selected' : '' }}>True</option>
                                  </select>
                                </div>
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
