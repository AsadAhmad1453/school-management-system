@extends('admin.layout.master')
@section('content')
    <div class="row mb-4">
        <div class="col-md">
            <div class="card">
                <h5 class="card-header">Permissions</h5>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="post" action="{{route('roles.update',$role->id)}}">
                        @csrf
                        @method('patch')
                        <div class="mb-3">
                            <label class="form-label" for="bs-validation-name">Name</label>
                            <input type="text" class="form-control" id="bs-validation-name" name="name" placeholder="BSCS-2019" value="{{$role->name}}" required/>
                            <div class="valid-feedback"> Looks good!</div>
                            <div class="invalid-feedback"> Please enter Role name.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-validation-name">Permissions List</label>
                            <br>
                            @foreach($permission as $value)
                                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                    {{ $value->name }}</label>
                                <br/>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Bootstrap Validation -->
    </div>
@endsection
