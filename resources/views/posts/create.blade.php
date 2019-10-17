@extends('layouts.app', ['title' => __('Post')])

@section('content')
    @include('roles.partials.header', ['title' => __('Add Post')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Post') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('comment.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('post.store') }}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Post information') }}</h6>
                            <div class="pl-lg-4">
                              <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="input-title">{{ __('Title') }}</label>
                                  <input type="text" name="title" id="input-title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="{{ old('title') }}" required autofocus>

                                  @if ($errors->has('title'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('title') }}</strong>
                                      </span>
                                  @endif
                              </div>
                              <div class="form-group{{ $errors->has('summary') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="input-name">{{ __('Summary') }}</label>
                                  <textarea class="form-control form-control-alternative{{ $errors->has('summary') ? ' is-invalid' : '' }}" rows="4" placeholder="{{ __('Summary') }}" name="summary">{{ old('summary') }}</textarea>
                                  @if ($errors->has('summary'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('summary') }}</strong>
                                      </span>
                                  @endif
                              </div>

                              <div class="form-group{{ $errors->has('body') ? ' has-danger' : '' }}">
                                  <label class="form-control-label" for="input-name">{{ __('Body') }}</label>
                                  <textarea id="body" class="form-control form-control-alternative{{ $errors->has('body') ? ' is-invalid' : '' }}" rows="4" placeholder="{{ __('Body') }}" name="body">{{ old('body') }}</textarea>
                                  @if ($errors->has('body'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('body') }}</strong>
                                      </span>
                                  @endif
                              </div>

                              <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Publish') }}</label>
                                <select class="form-control" name="live">
                                  <option value="0">False</option>
                                  <option value="1">True</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label class="form-control-label" for="input-name">{{ __('Category') }}</label>
                                <select class="form-control" name="post_category_id">
                                  @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                  @endforeach
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

@push('js')
<script>
  tinymce.init({
    selector:'#body',
    plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table paste imagetools wordcount"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    content_css: [
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      '//www.tiny.cloud/css/codepen.min.css'
    ]
  })
</script>
@endpush
