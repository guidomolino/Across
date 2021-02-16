@extends('layouts.main-layout')
@section('form')
  <div class="card">
    <div class="card-header">
      <h3>Test di selezione</h3>
    </div>
    <div class="card-body">
      <form class="form-inline" action="{{route('form-store')}}" method="post">
        @csrf
        @method('POST')
        <div class="form-group mx-auto mb-2">
          <input class="form-control @error('text') is-invalid @enderror" id="text" type="text" name="text" placeholder="">
          @error('text')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
      </form>
    </div>
  </div>
@endsection
