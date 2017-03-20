@extends('layouts.app')

@section('content')
<div>
    <ul class="nav nav-tabs" role="tablist">
        <li class="active">
            <a href="{{ secure_url('account/settings') }}" aria-controls="settings" role="tab" data-toggle="tab">Settings</a>
        </li>
        <li>
            <a href="#subscription" aria-controls="subscription" role="tab" data-toggle="tab">Subscription</a>
        </li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="settings">
            @include('account.settings')
        </div>
        <div role="tabpanel" class="tab-pane" id="subscription">...</div>
    </div>
</div>
@endsection
