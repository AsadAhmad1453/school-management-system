@extends('admin.layout.master')
@section('content')
    <div class="row mb-4">
        <!-- Bootstrap Validation -->
        <div class="col-md">
            <div class="card">
                <h5 class="card-header">Program Batches</h5>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="post" action="{{route('users.store')}}">
                        @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Name</label>
                                    <input type="text" class="form-control" id="bs-validation-name" name="name" placeholder="Your Name"
                                           required/>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please enter name.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Email</label>
                                    <input type="email" class="form-control" id="bs-validation-name" name="email" placeholder="example@gmail.com"
                                           required/>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please enter email.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Phone</label>
                                    <input type="text" class="form-control" id="bs-validation-name" name="phone" placeholder="0307*******"
                                           required/>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please enter Phone.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Password</label>
                                    <input type="password" class="form-control" id="bs-validation-name" name="password" placeholder="*******"
                                           required/>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please enter Password.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Confirm Password</label>
                                    <input type="password" class="form-control" id="bs-validation-name" name="password_confirmation" placeholder="*******"
                                           required/>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please enter Confirm Password.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-country">Gender</label>
                                    <select class="form-select" id="bs-validation-country" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please select gender</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="">Module Permissions</label>
                                <hr>
                                @foreach($roles as $role)
                                    <fieldset>
                                        <input type="checkbox" name="roles[]" value="{{$role->id}}" id="{{$role->id}}"
                                               style="margin-right: 5px;">
                                        <label class="label-info" for="{{$role->id}}">{{$role->name}}</label>
                                        <hr style="margin: 5px;"/>
                                    </fieldset>
                                @endforeach

                            </div>
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
