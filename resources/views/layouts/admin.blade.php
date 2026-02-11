<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="{{asset('contents/admin')}}/css/all.min.css">
    <link rel="stylesheet" href="{{asset('contents/admin')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('contents/admin')}}/css/datatables.min.css">
    <link rel="stylesheet" href="{{asset('contents/admin')}}/css/style.css">
  </head>

  <body>
@php
  // Role helpers
  $role = strtolower(Auth::user()->role->role_name ?? '');
  $isAdmin   = $role === 'admin';
  $isManager = $role === 'manager';
  $isViewer  = $role === 'viewer';

  // Sidebar open state (active collapse)
  $incomeOpen  = request()->is('dashboard/income*');
  $expenseOpen = request()->is('dashboard/expense*');

  // Notifications
  $unreadCount = Auth::user()->unreadNotifications()->count();
  $notis = Auth::user()->notifications()->latest()->limit(8)->get();
@endphp

    <header class="header">
      <div class="container-fluid header_part">
        <div class="row align-items-center">
          <div class="col-md-9 col-sm-7 col-5">
            <div class="menu_bars">
              <button type="button" id="sidebarToggle" aria-label="Toggle sidebar">
                <i class="fa fa-bars"></i>
              </button>
            </div>
          </div>

          <div class="col-md-3 col-sm-5 col-7 top_right_menu text-end">
            <div class="d-inline-flex align-items-center gap-2">

              {{-- Notifications --}}
              <div class="dropdown notification_dropdown">
                <button class="btn notification_btn position-relative"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        id="notiBtn">
                  <i class="fas fa-bell"></i>

                  <span class="notification_badge" id="notiBadge" style="{{ $unreadCount > 0 ? '' : 'display:none;' }}">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                  </span>
                </button>

                <ul class="dropdown-menu dropdown-menu-end notification_menu" id="notiMenu">
                  <li class="notification_topbar d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Notification</span>
                    <button class="btn btn-link p-0 text-decoration-none" type="button" id="clearAllBtn">Clear All</button>
                  </li>

                  @forelse($notis as $n)
                    @php $d = $n->data; @endphp
                    <li>
                      <a class="dropdown-item notification_item {{ $n->read_at ? '' : 'fw-bold' }}"
                        href="{{ $d['url'] ?? '#' }}">
                        <div class="noti_icon">{{ $d['icon'] ?? '🔔' }}</div>
                        <div class="noti_text">
                          <div class="d-flex justify-content-between">
                            <div class="noti_title">{{ $d['title'] ?? 'Notification' }}</div>
                            <div class="noti_time">{{ $n->created_at->diffForHumans() }}</div>
                          </div>
                          @if(!empty($d['subtitle']))
                            <div class="noti_subtitle">{{ $d['subtitle'] }}</div>
                          @endif
                        </div>
                      </a>
                    </li>
                  @empty
                    <li><div class="px-3 py-3 text-muted">No notifications</div></li>
                  @endforelse

                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <a class="dropdown-item text-center small" href="{{ url('dashboard/notifications') }}">View all</a>
                  </li>
                </ul>
              </div>
              {{-- User dropdown --}}
              <div class="dropdown">
                <button class="btn top_right_btn dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">

                  <img
                    src="{{ Auth::user()->photo ? asset('uploads/users/'.Auth::user()->photo) : asset('contents/admin/images/avatar.png') }}"
                    class="top_avatar"
                    alt="avatar"
                  >

                  <span class="top_user">
                    <span class="top_name">{{ Auth::user()->name }}</span>
                    <small class="top_role">{{ Auth::user()->role->role_name ?? 'User' }}</small>
                  </span>

                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="{{ route('dashboard.profile') }}"><i class="fas fa-user-tie me-2"></i> My Profile</a></li>
                  <li><a class="dropdown-item" href="{{ route('dashboard.account') }}"><i class="fas fa-cog me-2"></i> Manage Account</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                      onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                      <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                  </li>
                </ul>
              </div>



            </div>
          </div>
        </div>
      </div>
    </header>

    <section>
      <div class="container-fluid content_part">
        <div class="row">
          {{-- Sidebar --}}
          <div class="col-md-2 sidebar_part" id="sidebar">
            <div class="logo">
              <img src="{{asset('contents/admin')}}/images/FinOps_Logo.png" alt="finops_logo"/>
            </div>

            <div class="menu">
              <ul class="list-unstyled">

                <li>
                  <a href="{{ url('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                  </a>
                </li>

                <li>
                  <a href="{{ url('dashboard/user') }}" class="{{ request()->is('dashboard/user*') ? 'active' : '' }}">
                    <i class="fas fa-user-circle"></i> Users
                  </a>
                </li>

                {{-- Income --}}
                <li>
                  <a class="dropdown-toggle {{ $incomeOpen ? '' : 'collapsed' }}"
                     data-bs-toggle="collapse"
                     href="#incomeMenu"
                     role="button"
                     aria-expanded="{{ $incomeOpen ? 'true' : 'false' }}">
                    <i class="fas fa-wallet"></i> Income
                  </a>

                  <ul class="collapse list-unstyled ps-3 {{ $incomeOpen ? 'show' : '' }}" id="incomeMenu">
                    <li>
                      <a class="dropdown-item bg-transparent"
                         href="{{ url('dashboard/income') }}">Income Main</a>
                    </li>
                    <li>
                      <a class="dropdown-item bg-transparent"
                         href="{{ url('dashboard/income/category') }}">Income Category</a>
                    </li>
                  </ul>
                </li>

                {{-- Expense --}}
                <li>
                  <a class="dropdown-toggle {{ $expenseOpen ? '' : 'collapsed' }}"
                     data-bs-toggle="collapse"
                     href="#expenseMenu"
                     role="button"
                     aria-expanded="{{ $expenseOpen ? 'true' : 'false' }}">
                    <i class="fas fa-coins"></i> Expense
                  </a>

                  <ul class="collapse list-unstyled ps-3 {{ $expenseOpen ? 'show' : '' }}" id="expenseMenu">
                    <li>
                      <a class="dropdown-item bg-transparent"
                         href="{{ url('dashboard/expense') }}">Expense Main</a>
                    </li>
                    <li>
                      <a class="dropdown-item bg-transparent"
                         href="{{ url('dashboard/expense/category') }}">Expense Category</a>
                    </li>
                  </ul>
                </li>

                {{-- Reports --}}
                <li>
                  <a href="{{ url('dashboard/report') }}" class="{{ request()->is('dashboard/report*') ? 'active' : '' }}">
                    <i class="fas fa-file"></i> Reports
                  </a>
                </li>

                {{-- Recycle (admin + manager only) --}}
                @if($isAdmin || $isManager)
                  <li>
                    <a href="{{ url('dashboard/recycle') }}" class="{{ request()->is('dashboard/recycle*') ? 'active' : '' }}">
                      <i class="fas fa-trash"></i> Recycle
                    </a>
                  </li>
                @endif

                {{-- Logout --}}
                <li>
                  <a href="{{ route('logout') }}"
                     onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                  </a>
                </li>

              </ul>
            </div>
          </div>

          {{-- Content --}}
          <div class="col-md-10 content" id="mainContent">
            <div class="row">
              <div class="col-md-12 breadcumb_part">
                <div class="bread">
                  <h4>@yield('title', 'Dashboard')</h4>
                </div>
              </div>
            </div>

            @yield('page')
          </div>

        </div>
      </div>
    </section>

    {{-- One logout form only (no duplicates) --}}
    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display:none;">
      @csrf
    </form>

    @yield('scripts')

    {{-- Notifications JS --}}
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const csrf  = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const badge = document.getElementById('notiBadge');
        const menu  = document.getElementById('notiMenu');
        const notiBtn = document.getElementById('notiBtn');

        const markAllReadUrl = "{{ route('dashboard.notifications.markAllRead') }}";
        const clearAllUrl    = "{{ route('dashboard.notifications.clearAll') }}";

        function setBadge(count){
          if(!badge) return;
          if(count > 0){
            badge.style.display = '';
            badge.textContent = count > 9 ? '9+' : count;
          } else {
            badge.style.display = 'none';
            badge.textContent = '0';
          }
        }

        // Bell click -> mark all read
        notiBtn?.addEventListener('click', function(){
          fetch(markAllReadUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
          }).then(() => setBadge(0));
        });

        // Clear All
        document.addEventListener('click', function(e){
          const btn = e.target.closest('#clearAllBtn');
          if(!btn) return;

          e.preventDefault();

          fetch(clearAllUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
          })
          .then(async (r) => {
            if(!r.ok){
              const t = await r.text();
              console.log('ClearAll error:', t);
              return null;
            }
            return r.json();
          })
          .then((data) => {
            if(!data) return;

            setBadge(0);

            if(menu){
              menu.innerHTML = `
                <li class="notification_topbar d-flex justify-content-between align-items-center">
                  <span class="fw-bold">Notification</span>
                  <button class="btn btn-link p-0 text-decoration-none" type="button" id="clearAllBtn">Clear All</button>
                </li>
                <li><div class="px-3 py-3 text-muted">No notifications</div></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center small" href="{{ url('dashboard/notifications') }}">View all</a></li>
              `;
            }
          })
          .catch(err => console.log('ClearAll fetch failed:', err));
        });
      });
    </script>

    <script src="{{asset('contents/admin')}}/js/jquery-3.6.0.min.js"></script>
    <script src="{{asset('contents/admin')}}/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('contents/admin')}}/js/datatables.min.js"></script>
    <script src="{{asset('contents/admin')}}/js/custom.js"></script>
  </body>
</html>
