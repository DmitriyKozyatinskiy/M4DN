<nav class="Header navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" id="js-tray-trigger">
        <img alt="Sneekr" title="Sneekr" src="{{ secure_asset('images/tray.png')}}" class="Tray__Trigger js-tray-trigger">
      </a>
      <div class="Tray js-tray" id="js-tray">
        <a href="{{ secure_url('history') }}" class="Tray__Item">History</a>
        <a href="{{ secure_url('devices/show') }}" class="Tray__Item">Devices</a>
        <a href="{{ secure_url('downloads') }}" class="Tray__Item">Downloads</a>
        <a href="{{ secure_url('account/subscription') }}" class="Tray__Item">Subscription</a>
        <a href="{{ secure_url('account/settings') }}" class="Tray__Item">Account Settings</a>
        <a href="{{ secure_url('account/logout') }}" class="Tray__Item">Logout</a>
      </div>
      <a class="navbar-brand" href="{{ secure_url('/') }}">
        {{ config('app.name', 'Sneekr') }}
      </a>
    </div>

    <div class="collapse navbar-collapse" id="app-navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
          <li><a href="{{ secure_url('/login') }}">Login</a></li>
          <li><a href="{{ secure_url('/register') }}">Registration</a></li>
        @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="{{ secure_url('/logout') }}" id="js-logout">Logout</a>
                <form class="Header__LogoutForm" id="logout-form" action="{{ url('/logout') }}" method="POST">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>