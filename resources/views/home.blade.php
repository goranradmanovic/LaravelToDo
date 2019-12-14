@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-12">
            @if (session('status'))
                <infomessage-component :message="{{ session('status') }}" :alert-type="'alert-success'"></infomessage-component>
            @endif

            <infomessage-component :message="'You are logged in!'" :alert-type="'alert-success'"></infomessage-component>
          </div>
      </div>

      <div class="row justify-content-center">
          <div class="col-md-12">
            <userslist-component></userslist-component>
          </div>
      </div>
  </div>
@endsection
