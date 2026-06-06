<nav class="navbar navbar-expand-lg bg-dark navbar-dark px-sm-4 p-2"  id="header">
    <div class="container-fluid">
        
        <!-- Left: Mobile Hamburger Menu -->
        <button class="btn text-white p-0 d-lg-none mobile-offcanvas" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" >
            <i class="fas fa-bars"></i>
        </button>
        <!-- Left: Hamburger Menu -->
        <button class="btn text-white p-0 d-lg-block d-none">
            <i class="fas fa-bars hamburg-icon"></i>
        </button>

        <!-- Right: Icons -->
        <div class="d-flex align-items-center gap-4 header-right-content">


            <!-- Profile Picture -->
            <div class="dropdown">
                <div class="header-profile-image" data-bs-toggle="dropdown" aria-expanded="false">
                    @php
                    $user = auth()->user();
                    @endphp
                    @if (!empty($user->profile_pic))
                        <img src="{{ Storage::url('profile_images/' . $user->profile_pic) }}" alt="Profile" class="rounded-circle img-fluid auth-imgs me-2 cursor-pointer tansition-opacity object-fit-cove" width="32" height="32">
                    @else
                        <img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('admin_panel_logo_img', config('constants.company_logo')) }}" alt="Profile" class="rounded-circle img-fluid auth-imgs me-2 cursor-pointer tansition-opacity object-fit-cove" width="32" height="32">
                    @endif
                </div>
                <!-- ==== Profile list start ==== -->
                <ul class="dropdown-menu dropdown-menu-end shadow inline-size-2 py-0 px-2 pullDown">
                    <li>
                        <a class="dropdown-item border-bottom d-flex align-items-center gap-2 fw-medium" href="{{ route('admin.edit-user-profile') }}">
                            <i class="bi bi-person-circle"></i>
                            <span>{{ __('labels.profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item border-bottom d-flex align-items-center gap-2 fw-medium" href="{{ route('admin.change-password') }}">
                            <i class="fa-solid fa-key"></i>
                            <span>{{ __('labels.change_password') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2 fw-medium" href="{{ route('admin.logout') }}">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>{{ __('labels.sign_out') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
@javascript([
'delete_modal_title' => __('labels.delete_modal_title'),
'delete_modal_text' => __('labels.delete_modal_text'),
'confirm_button_modal' => __('labels.confirm_button_modal'),
'cancel' => __('buttons.cancel'),
'error_message' => __('labels.error_message'),
])
