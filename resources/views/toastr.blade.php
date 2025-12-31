@extends('layouts.app')

@section('content')
<div class="text-center">
    <h2>Laravel 12 Toastr Notifications Example</h2>
    <a href="/success" class="btn btn-success mt-3">Success</a>
    <a href="/error" class="btn btn-danger mt-3">Error</a>
    <a href="/info" class="btn btn-info mt-3">Info</a>
    <a href="/warning" class="btn btn-warning mt-3">Warning</a>
</div>
@endsection
