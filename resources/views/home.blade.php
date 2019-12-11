@extends('layouts.app')

@section('content')
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              @if (session('status'))
                  <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                  </div>
              @endif

              <strong>You are logged in!</strong>

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
      </div>

      <div class="row justify-content-center">
          <div class="col-md-12">
            <userslist-component :users="{{ $users }}"></userslist-component>
          </div>
      </div>
  </div>
@endsection
