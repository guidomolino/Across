@extends('layouts.main-layout')
@section('form')
  <div class="card">
    <div class="card-header">
      <h3>Test di selezione</h3>
    </div>
    <div class="card-body">
      <form class="form-inline" action="" method="post">
        <div class="form-group mx-sm-3 mb-2">
          <input class="form-control" type="text" placeholder="Text me...">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
      </form>
    </div>
  </div>
@endsection
