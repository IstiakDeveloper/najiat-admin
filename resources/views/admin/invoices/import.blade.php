@extends('layouts.app')

@section('content')
<form action="{{ route('import.invoices') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">Import Invoices</button>
</form>
@endsection
