@extends('admin.layout.master')
@section('style')
    <link rel="stylesheet" href="{{asset('admin/select2/dist/css/select2.min.css')}}">
@endsection
@section('content')
    <div class="row mb-4">
        <div class="col-md">
            <div class="card">
                <h5 class="card-header">Rooms</h5>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="post" action="{{route('courses.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Course Code</label>
                                    <input type="text" name="course_code"class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Professors</label>

                                    <div class="select2-wrapper">
                                        <select id="professors-select" name="professor_ids[]" class="form-control select2"
                                                multiple>
                                            <option value="">Select professors</option>
                                            @foreach ($professors as $professor)
                                                <option value="{{ $professor->id }}" {{ in_array($professor->id, old('professor_ids', [])) ? 'selected' : '' }}>
                                                    {{ $professor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px;">
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

@section('script')
    <script src="{{asset('admin/select2/dist/js/select2.full.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(".select2").select2();
        });
    </script>

@endsection
