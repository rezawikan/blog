@extends('layouts.app', ['title' => __('Role')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <h3 class="mb-0">{{ __('Roles') }}</h3>
                            </div>
                            <div class="col-6">
                              <role-search-component />
                            </div>
                            <div class="col-3 text-right">
                                <a href="{{ route('role.create') }}" class="btn btn-sm btn-primary">{{ __('Add Role') }}</a>
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
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-right">
                                          @can('update', $role)
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                  <form action="{{ route('role.destroy', $role) }}" method="post">
                                                      @csrf
                                                      @method('delete')

                                                      <a class="dropdown-item" href="{{ route('role.edit', $role) }}">{{ __('Edit') }}</a>
                                                      @can('delete', $role)
                                                      <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this role?") }}') ? this.parentElement.submit() : ''">
                                                          {{ __('Delete') }}
                                                      </button>
                                                      @endcan
                                                  </form>
                                                </div>
                                            </div>
                                          @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $roles->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
