@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Change Password -->
            <div class="card mb-4">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="POST" action="{{route('post.password')}}">
                        @csrf
                        <div class="row">
                        <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                            <label class="form-label" for="bs-validation-name">Current Password</label>

                            <div class="input-group input-group-merge has-validation">
                                <input type="password" class="form-control" id="bs-validation-name" name="password" placeholder="Enter Current Password"
                                       required/>
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                <div class="valid-feedback"> Looks good!</div>
                                <div class="invalid-feedback"> Please enter current Password.</div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6 form-password-toggle fv-plugins-icon-container">
                            <label class="form-label" for="bs-validation-name">New Password</label>

                            <div class="input-group input-group-merge has-validation">
                                <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter New Password"
                                       required/>
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                <div class="valid-feedback"> Looks good!</div>
                                <div class="invalid-feedback"> Please enter new password.</div>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <p class="fw-medium mt-2">Password Requirements:</p>
                            <ul class="ps-3 mb-0">
                                <li class="mb-1">
                                    Minimum 8 characters long - the more, the better
                                </li>
                                <li class="mb-1">At least one lowercase character</li>
                                <li>At least one number, symbol, or whitespace character</li>
                            </ul>
                        </div>
                        <div class="col-12 mt-1">
                            <button type="submit" class="btn btn-primary me-2">Update password</button>
                        </div>
                </div>
                <input type="hidden"></form>
            </div>
        </div>
    </div>
    </div>

@endsection
