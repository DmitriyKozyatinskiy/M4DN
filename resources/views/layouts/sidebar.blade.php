<div class="Sidebar">
  <a href="{{ secure_url('history') }}" class="Sidebar__Item">History</a>
  <a href="{{ secure_url('devices/show') }}" class="Sidebar__Item">Devices</a>
  <a href="{{ secure_url('downloads') }}" class="Sidebar__Item">Downloads</a>
  <a href="{{ secure_url('account/subscription') }}" class="Sidebar__Item">Subscription</a>
  <a href="{{ secure_url('account/billing') }}" class="Sidebar__Item">Billing</a>
  <a href="{{ secure_url('account/settings') }}" class="Sidebar__Item">Account Settings</a>

  {{--@if (Auth::check() && Auth::user()->isAdmin)--}}
  {{--<a href="#" class="Sidebar__Item">Admin Panel</a>--}}
  {{--@endif--}}
</div>
