<!-- resources/views/products.blade.php -->
@extends('layouts.app')

@section('content')
  <div id="app">
    <ProductApp />
  </div>

  <script src="{{ mix('js/app.js') }}"></script>
@endsection
