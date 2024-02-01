@extends('admin.layout.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif
        <div class="card">
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('rooms.index') }}">Back</a>
                    </span>
            <div class="card-body">
                <div class="lead">
                    <strong>Name:</strong>
                    {{ $room->title }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
