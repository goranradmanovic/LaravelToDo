@extends('../layouts.app')

@section('content')
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
            <createtask-component :user-id="{{ auth()->user()->id }}"></createtask-component>
          </div>
      </div>
  </div>
@endsection
