<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas">
    <span class="position-absolute sidebar-offcanvas-close-btn translate-middle-y p-2 bg-primary text-white d-lg-none"
        data-bs-dismiss="offcanvas"><i class="bi bi-x-lg"></i></span>

    <div class="sidebar overflow-hidden" id="sidebar">
        <div class="sidebar-inner h-100 overflow-hidden">
            <div class="sidebar-header p-3">
                <div class="sidebar-logo-area">
                    <div class="full-logo text-center tansition-opacity">
                        <a href="{{ route('admin.dashboard.index') }}" class="m-auto w-75">
                            <img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('sidebar_logo_img', config('constants.company_logo')) }}" alt="Logo" class="m-auto img-fluid w-75" />
                        </a>
                    </div>
                </div>
            </div>

            <div class="sidebar-menus pt-0 pb-5 px-1 overflow-x-hidden overflow-y-auto">
                <ul class="accordion list-unstyled" id="sidebarMenusAccordian">

                    {{-- Dashboard --}}
                    <li class="accordion-item">
                        <a class="accordion-button cursor-pointer no-arrow" href="{{ route('admin.dashboard.index') }}">
                            <i class="fa-solid fa-gauge"></i>
                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">{{ __('labels.dashboard') }}</span>
                        </a>
                    </li>

                    {{-- User Management --}}
                    @can('user-management')
                        <li class="accordion-item @if (Request::routeIs('admin.roles.*') || Request::routeIs('admin.permissions.*') || Request::routeIs('admin.users.*')) active @endif">
                            <a class="accordion-button cursor-pointer @if (Request::routeIs('admin.roles.*') || Request::routeIs('admin.permissions.*') || Request::routeIs('admin.users.*')) @else collapsed @endif"
                                data-bs-toggle="collapse" data-bs-target="#user-management" aria-expanded="true">
                                <i class="fa-solid fa-users-gear"></i>
                                <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">{{ __('labels.user_management') }}</span>
                            </a>

                            <div id="user-management" class="accordion-collapse collapse @if (Request::routeIs('admin.roles.*') || Request::routeIs('admin.permissions.*') || Request::routeIs('admin.users.*')) show @endif"
                                data-bs-parent="#sidebarMenusAccordian">
                                <div class="accordion-body py-0 px-2">
                                    <ul class="nav flex-column">
                                        @can('role-list')
                                            <li>
                                                <a href="{{ route('admin.roles.index') }}" class="nav-link sidebar-menu-links @if (Request::routeIs('admin.roles.*')) active @endif">
                                                    <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">{{ __('labels.roles') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('permission-list')
                                            <li>
                                                <a href="{{ route('admin.permissions.index') }}" class="nav-link sidebar-menu-links @if (Request::routeIs('admin.permissions.*')) active @endif">
                                                    <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">{{ __('labels.permissions') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('user-list')
                                            <li>
                                                <a href="{{ route('admin.users.index') }}" class="nav-link sidebar-menu-links @if (Request::routeIs('admin.users.*')) active @endif">
                                                    <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">{{ __('labels.users') }}</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endcan

                    {{-- Banners --}}
                    <li class="accordion-item">
                        <a class="accordion-button cursor-pointer no-arrow @if (Request::routeIs('admin.banners.*')) @else collapsed @endif"
                            href="{{ route('admin.banners.index') }}">
                            <i class="fa-solid fa-image"></i>
                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Banners</span>
                        </a>
                    </li>

                    {{-- Destinations --}}
                    <li class="accordion-item">
                        <a class="accordion-button cursor-pointer no-arrow @if (Request::routeIs('admin.destinations.*')) @else collapsed @endif"
                            href="{{ route('admin.destinations.index') }}">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Destinations</span>
                        </a>
                    </li>

                    {{-- Tour Packages --}}
                    <li class="accordion-item">
                        <a class="accordion-button cursor-pointer no-arrow @if (Request::routeIs('admin.tours.*')) @else collapsed @endif"
                            href="{{ route('admin.tours.index') }}">
                            <i class="fa-solid fa-suitcase-rolling"></i>
                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Tour Packages</span>
                        </a>
                    </li>

                    {{-- Blog Management --}}
                    <li class="accordion-item @if (Request::routeIs('admin.blogs.*') || Request::routeIs('admin.blog-categories.*') || Request::routeIs('admin.authors.*')) active @endif">
                        <a class="accordion-button cursor-pointer @if (Request::routeIs('admin.blogs.*') || Request::routeIs('admin.blog-categories.*') || Request::routeIs('admin.authors.*')) @else collapsed @endif"
                            data-bs-toggle="collapse" data-bs-target="#blog-management" aria-expanded="true">
                            <i class="fa-solid fa-newspaper"></i>
                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Blog</span>
                        </a>

                        <div id="blog-management" class="accordion-collapse collapse @if (Request::routeIs('admin.blogs.*') || Request::routeIs('admin.blog-categories.*') || Request::routeIs('admin.authors.*')) show @endif"
                            data-bs-parent="#sidebarMenusAccordian">
                            <div class="accordion-body py-0 px-2">
                                <ul class="nav flex-column">
                                      @can('blog-list')
                                    <li>
                                        <a href="{{ route('admin.blog-categories.index') }}" class="nav-link sidebar-menu-links @if (Request::routeIs('admin.blog-categories.*')) active @endif">
                                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Blog Categories</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('author-list')
                                    <li>
                                        <a href="{{ route('admin.authors.index') }}" class="nav-link sidebar-menu-links @if (Request::routeIs('admin.authors.*')) active @endif">
                                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Authors</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('blog-list')
                                    <li>
                                        <a href="{{ route('admin.blogs.index') }}" class="nav-link sidebar-menu-links @if (Request::routeIs('admin.blogs.*')) active @endif">
                                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Blog Posts</span>
                                        </a>
                                    </li>
                                   @endcan
                                </ul>
                            </div>
                        </div>
                    </li>

                    {{-- Gallery --}}
                    <li class="accordion-item">
                        <a class="accordion-button cursor-pointer no-arrow @if (Request::routeIs('admin.galleries.*')) @else collapsed @endif"
                            href="{{ route('admin.galleries.index') }}">
                            <i class="fa-solid fa-images"></i>
                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Gallery</span>
                        </a>
                    </li>

                    {{-- Reviews --}}
                    <li class="accordion-item">
                        <a class="accordion-button cursor-pointer no-arrow @if (Request::routeIs('admin.reviews.*')) @else collapsed @endif"
                            href="{{ route('admin.reviews.index') }}">
                            <i class="fa-solid fa-star"></i>
                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Reviews</span>
                        </a>
                    </li>

                    {{-- Enquiries --}}
                    <li class="accordion-item">
                        <a class="accordion-button cursor-pointer no-arrow @if (Request::routeIs('admin.enquiries.*')) @else collapsed @endif"
                            href="{{ route('admin.enquiries.index') }}">
                            <i class="fa-solid fa-envelope-open-text"></i>
                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Enquiries</span>
                        </a>
                    </li>

                    {{-- Settings --}}
                    <li class="accordion-item">
                        <a class="accordion-button cursor-pointer no-arrow @if (Request::routeIs('admin.settings.*')) @else collapsed @endif"
                            href="{{ route('admin.settings.index') }}">
                            <i class="fa-solid fa-gear"></i>
                            <span class="sidebar-menus-name ms-2 tansition-opacity text-primary">Settings</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="d-flex align-items-center px-3 py-3 bg-secondary sidebar-logout-menu position-absolute end-0 start-0 bottom-0">
                <div class="d-flex align-items-center dropdown-toggle cursor-pointer justify-center" id="navbarDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    @php $user = auth()->user(); @endphp
                    @if (!empty($user->profile_pic))
                        <img src="{{ Storage::url('profile_images/' . $user->profile_pic) }}" alt="User Avatar"
                            class="rounded-circle img-fluid auth-imgs me-2 cursor-pointer tansition-opacity object-fit-cove">
                    @else
                        <img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('admin_panel_logo_img', config('constants.company_logo')) }}" alt="User Avatar"
                            class="rounded-circle img-fluid auth-imgs me-2 cursor-pointer tansition-opacity object-fit-cove">
                    @endif
                    <span class="d-block user-name text-nowrap cursor-pointer tansition-opacity text-white ms-2">{{ $user->name ?? '' }}</span>
                </div>

                <ul class="user-dropdown-menu dropdown-menu dropdown-menu-end shadow inline-size-2 py-0 px-2">
                    <li>
                        <a class="dropdown-item border-bottom d-flex align-items-center gap-2 fw-medium"
                            href="{{ route('admin.edit-user-profile') }}">
                            <i class="bi bi-person-circle"></i>
                            <span>{{ __('labels.profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item border-bottom d-flex align-items-center gap-2 fw-medium"
                            href="{{ route('admin.change-password') }}">
                            <i class="fa-solid fa-key"></i>
                            <span>{{ __('labels.change_password') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 fw-medium"
                            href="{{ route('admin.logout') }}">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>{{ __('labels.sign_out') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
