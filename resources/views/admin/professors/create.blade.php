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
                    <form class="needs-validation" novalidate method="post" action="{{route('professors.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Courses</label>

                                    <div class="select2-wrapper">
                                        <select id="courses-select" name="course_ids[]" class="form-control select2"
                                                multiple>
                                            <option value="">Select courses</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->course_code }} {{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Unavailable periods</label>

                                    <div class="select2-wrapper">
                                        <select id="periods-select" name="unavailable_periods[]"
                                                class="form-control select2" multiple>
                                            <option value="">Select unavailable periods for this lecturer</option>
                                            @foreach ($days as $day)
                                                @foreach ($timeslots as $timeslot)
                                                    <option value="{{ $day->id  }},{{ $timeslot->id }}">
                                                        {{ $day->name . " " . $timeslot->time }}
                                                    </option>
                                                @endforeach
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
