@extends('admin.layout.master')
@section('style')
    <style>
        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <hr class="my-0">
                <div class="card-body">
                    <form id="formAccountSettings"  action="{{route('post.profile')}}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">Name</label>
                                    <input class="form-control" type="text" id="firstName" name="name" value="{{Auth::user()->name}}"  maxlength="35" autofocus/>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="phoneNumber">Designation</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="designation" name="designation" class="form-control" value="{{Auth::user()->designation}}"  maxlength="20" placeholder="Enter Designation"/>
                                    </div>
                                </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="bs-validation-event">Select Department</label>
                                        <select class="form-select" id="bs-validation-event" name="department" required>
                                            <option value="">Select Department</option>
                                            @foreach($departments as $str)
                                                <option value="{{$str->id}}" {{($str->id==Auth::user()->department)?'selected':''}}>{{$str->name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-feedback"> Looks good!</div>
                                        <div class="invalid-feedback"> Please select event venue</div>
                                    </div>

                                <div class="mb-3">
                                    <label class="form-label" for="phoneNumber">Date Of Birth</label>
                                    <div class="input-group input-group-merge">
                                        <input type="date" id="dob" name="dob" class="form-control" value="{{Auth::user()->dob}}" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">pk(+92)</span>
                                        <input type="text" id="phoneNumber" name="phone" class="form-control" value="{{Auth::user()->phone}}"  maxlength="20" placeholder="202 555 0111"/>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-country">Gender</label>
                                    <select class="form-select" id="bs-validation-country" name="gender" required="">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{(Auth::user()->gender=="Male") ? 'selected':''}}>Male</option>
                                        <option value="Female" {{(Auth::user()->gender=="Female") ? 'selected':''}}>Female</option>
                                    </select>
                                    <div class="valid-feedback"> Looks good!</div>
                                    <div class="invalid-feedback"> Please select gender</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="offset-md-12" style="margin: auto; width: 250px !important;">
                                        <img style="width: 100%; border:2px solid #696cff; padding: 10px" src=" {{(Auth::user()->image!=null) ? asset('admin/images/user/'.Auth::user()->image): asset('admin/images/user/imglogo.jpg')}}" alt="Logo">

                                        <div class="offset-md-12" style="width: auto;text-align: center; margin: 10px auto auto;">
                                            <div class="upload-btn-wrapper">
                                                <button class="btn btn-primary">Upload new photo</button>
                                                <input type="file" name="image" id="image"/>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="offset-md-12 avatar" style="margin: auto; width: 180px;text-align: center;">
                                        <div class="progress" id="p2" style="display:none;height:30px; line-height: 30px;">

                                            <div class="progress-bar progress-bar-striped bg-primary" id="progress_bar_p2" role="progressbar" style="width:0%;">0%</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $('#image').change(function () {
            var file_element = document.getElementById('image');

            var progress_bar = document.getElementById('p2');

            var progress_bar_process = document.getElementById('progress_bar_p2');
            let myfile = $(this).val();
            var ext = myfile.split(".").pop()
            ext = ext.toLowerCase();
            if (ext === "png" || ext === "jpg" || ext === "jpeg") {
                var form_data = new FormData();

                form_data.append('image', file_element.files[0]);
                let name = 'inter';
                form_data.append('data', name);
                form_data.append('_token', document.getElementsByName('_token')[0].value);

                progress_bar.style.display = 'block';

                var ajax_request = new XMLHttpRequest();

                ajax_request.open("POST", "{{ route('post.image') }}");

                ajax_request.upload.addEventListener('progress', function (event) {

                    var percent_completed = Math.round((event.loaded / event.total) * 100);

                    progress_bar_process.style.width = percent_completed + '%';

                    progress_bar_process.innerHTML = percent_completed + '% completed';

                });

                ajax_request.addEventListener('load', function (event) {

                    var file_data = JSON.parse(event.target.response);
                    //console.log(file_data)
                    file_element.value = '';
                    location.replace(location.href);


                });

                ajax_request.send(form_data);


            } else {
                alert("Only ( JPG, JPEG, PNG ) is  allowed");
            }
        });
    </script>
@endsection
