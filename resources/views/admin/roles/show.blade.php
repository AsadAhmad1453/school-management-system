@extends('admin.layout.master')

@section('style')
    <link rel="stylesheet" href="{{asset('admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Roles List</h5>
            </div>
            <div class="col-md-6">
                <a href="{{route('roles.create')}}" class="btn btn-primary float-end m-3">Create</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6" style="padding-left: 40px">
                @if(!empty($rolePermissions))
                    @foreach($rolePermissions as $permission)
                        <i class="fa fa-check"></i> {{ $permission->name }}
                    @endforeach
                @endif
            </div>
        </div>

    </div>

@endsection










@extends('admin.layout.master')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif
        <div class="card">
            <div class="card-header">Role
                @can('role-create')
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}">Back</a>
                    </span>
                @endcan
            </div>
            <div class="card-body">
                <div class="lead">
                    <strong>Name:</strong>
                    {{ $role->name }}
                </div>
                <div class="lead">
                    <strong>Permissions:</strong>
                    @if(!empty($rolePermissions))
                        @foreach($rolePermissions as $permission)
                            <label class="badge badge-success">{{ $permission->name }}</label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
