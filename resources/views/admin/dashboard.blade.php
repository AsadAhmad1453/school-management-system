@extends('admin.layout.master')
@section('content')
    @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('Super Admin')))
    <div class="row">


        <div class="col-12 col-sm-6 col-md-3 col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <span class="d-block fw-medium">Total Users</span>
                    <h3 class="card-title mb-2">1</h3>
                </div>
            </div>
        </div>



    </div>
    @endif
@endsection
