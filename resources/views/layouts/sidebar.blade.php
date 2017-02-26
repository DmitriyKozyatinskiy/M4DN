<div class="Sidebar">
  <a href="{{ url('history')  }}" class="Sidebar__Item">History</a>
  <a href="{{ url('devices/show')  }}" class="Sidebar__Item">Devices</a>
  <a href="#" class="Sidebar__Item">Downloads</a>
  <a href="{{ url('account/subscription')  }}" class="Sidebar__Item">Subscription</a>
  <a href="{{ url('account/settings')  }}" class="Sidebar__Item">Account Settings</a>

  @if (Auth::check() && Auth::user()->isAdmin)
    <a href="#" class="Sidebar__Item">Admin Panel</a>
  @endif
</div>
