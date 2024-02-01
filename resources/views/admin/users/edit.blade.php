@extends('admin.layout.master')
@section('content')
    <div class="row mb-4">
        <div class="col-md">
            <div class="card">
                <h5 class="card-header">Edit User details</h5>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="post" action="{{route('users.update',$user->id)}}">
                        @csrf
                        @method('patch')
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Name</label>
                                    <input type="text" class="form-control" id="bs-validation-name" name="name" placeholder="BSCS-2019" value="{{$user->name}}" required/>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please enter Program Batch name.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Email</label>
                                    <input type="email" class="form-control" id="bs-validation-name" name="email" placeholder="BSCS-2019" value="{{$user->email}}" required/>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please enter email.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Phone Number</label>
                                    <input type="text" class="form-control" id="bs-validation-name" name="phone" placeholder="BSCS-2019" value="{{$user->phone}}" required/>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please enter Phone.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-country">Type</label>
                                    <select class="form-select" id="bs-validation-country" name="type" required>
                                        <option value="">Select type</option>
                                        <option value="admin" {{($user->type=="admin")?"selected":''}}>Admin</option>
                                        <option value="user" {{($user->type=="user")?"selected":''}}>User</option>

                                    </select>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please select gender</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-country">Gender</label>
                                    <select class="form-select" id="bs-validation-country" name="gender" required>
                                        <option value="">Select type</option>
                                        <option value="Male" {{($user->gender=="Male")?"selected":''}}>Male</option>
                                        <option value="Female" {{($user->gender=="Female")?"selected":''}}>Female</option>

                                    </select>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please select gender</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-country">Status</label>
                                    <select class="form-select" id="bs-validation-country" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="1" {{(1==$user->status)? 'selected':''}}>Active</option>
                                        <option value="0" {{(0==$user->status)? 'selected':''}}>In Active</option>
                                    </select>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please select Department Name</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="">Module Permissions</label>
                                <hr>
                                @foreach($roles as $role)
                                        <?php $count = 0; ?>
                                    @foreach($userRole as $user)
                                        @if($user->name==$role->name)
                                            <fieldset>
                                                <input type="checkbox" name="roles[]" value="{{$role->id}}" id="{{$role->id}}"
                                                       style="margin-right: 5px;" checked>
                                                <label class="label-info" for="{{$role->id}}">{{$role->name}}</label>
                                                <hr style="margin: 5px;"/>
                                            </fieldset>
                                                <?php $count = 1; ?>
                                        @endif
                                    @endforeach
                                    @if($count==0)
                                        <fieldset>
                                            <input type="checkbox" name="roles[]" value="{{$role->id}}" id="{{$role->id}}"
                                                   style="margin-right: 5px;">
                                            <label class="label-info" for="{{$role->id}}">{{$role->name}}</label>
                                            <hr style="margin: 5px;"/>
                                                <?php $count = 0; ?>
                                        </fieldset>
                                    @endif
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
