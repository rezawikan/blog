<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0 dropdown-toggle" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="badge badge-danger ml-2">4</span>
                    <i class="fas fa-bell"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-5">
                    <a class="dropdown-item waves-effect waves-light" href="#">Action <span class="badge badge-danger ml-2">4</span></a>
                    <a class="dropdown-item waves-effect waves-light" href="#">Another action <span class="badge badge-danger ml-2">1</span></a>
                    <a class="dropdown-item waves-effect waves-light" href="#">Something else here <span class="badge badge-danger ml-2">4</span></a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('home') }}">
                      <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                  </a>
              </li>
                {{-- <li class="nav-item">
                    <a class="nav-link {{ (request()->is('user-management*')) ? 'active' : '' }}" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fas fa-users"></i>
                        <span class="nav-link-text">{{ __('User Management') }}</span>
                    </a>
                    <div class="collapse {{ (request()->is('user-management*')) ? 'show' : '' }}" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                           @can('view', \App\Models\User::class)
                            <li class="nav-item">
                                <a class="nav-link  {{ (request()->is('user-management/user')) ? 'active' : '' }}" href="{{ route('user.index') }}">
                                    {{ __('Users') }}
                                </a>
                            </li>
                            @endcan
                            @can('view', \App\Models\Role::class)
                              <li class="nav-item">
                                  <a class="nav-link {{ (request()->is('user-management/role')) ? 'active' : '' }}" href="{{ route('role.index') }}">
                                      {{ __('Roles') }}
                                  </a>
                              </li>
                            @endcan
                            @can('view', \App\Models\Permission::class)
                              <li class="nav-item">
                                  <a class="nav-link {{ (request()->is('user-management/permission')) ? 'active' : '' }}" href="{{ route('permission.index') }}">
                                      {{ __('Permissions') }}
                                  </a>
                              </li>
                            @endcan
                        </ul>
                    </div>
                </li> --}}
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('profile.edit') }}">
                      <i class="fas fa-user text-blue"></i> {{ __('User profile') }}
                  </a>
              </li>
              @can('view', \App\Models\PostCategory::class)
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('post-category.index') }}">
                      <i class="fas fa-align-left text-blue"></i> {{ __('Post Categories') }}
                  </a>
              </li>
              @endcan
              @can('view', \App\Models\Post::class)
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('post.index') }}">
                      <i class="fas fa-newspaper text-blue"></i> {{ __('Posts') }}
                  </a>
              </li>
              @endcan
              @can('view', \App\Models\Tag::class)
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('tag.index') }}">
                      <i class="fas fa-tags text-blue"></i> {{ __('Tags') }}
                  </a>
              </li>
              @endcan
              @can('view', \App\Models\Comment::class)
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('comment.index') }}">
                      <i class="fas fa-comments text-blue"></i> {{ __('Comments') }}
                  </a>
              </li>
              @endcan
            </ul>

            @if (auth()->user()->hasPermissionWithRole(['view user', 'view role', 'view permission']))
              <!-- Divider -->
              <hr class="my-3">
              <!-- Heading -->
              <h6 class="navbar-heading text-muted">User Management</h6>
            @endif

            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
              @can('view', \App\Models\User::class)
                 <li class="nav-item">
                   <a class="nav-link  {{ (request()->is('user-management/user')) ? 'active' : '' }}" href="{{ route('user.index') }}">
                       {{ __('Users') }}
                   </a>
                 </li>
               @endcan
               @can('view', \App\Models\Role::class)
                 <li class="nav-item">
                   <a class="nav-link {{ (request()->is('user-management/role')) ? 'active' : '' }}" href="{{ route('role.index') }}">
                       {{ __('Roles') }}
                   </a>
                 </li>
               @endcan
               @can('view', \App\Models\Permission::class)
                 <li class="nav-item">
                   <a class="nav-link {{ (request()->is('user-management/permission')) ? 'active' : '' }}" href="{{ route('permission.index') }}">
                       {{ __('Permissions') }}
                   </a>
                 </li>
               @endcan
            </ul>
        </div>
    </div>
</nav>
