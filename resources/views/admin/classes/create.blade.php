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
                    <form class="needs-validation" novalidate method="post" action="{{ route('classes.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Courses <i class="fa fa-plus side-icon" title="Add Course" id="course-add"></i></label>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-7 col-xs-12">
                                            Course
                                        </div>

                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            Academic Period
                                        </div>

                                        <div class="col-md-3 col-sm-5 col-xs-12">
                                            Class Per Week
                                        </div>
                                    </div>

                                    <div id="courses-container">

                                    </div>
                                    <!-- Hidden template for courses -->
                                    <div id="course-template" class="hidden">
                                        <div class="row course-form appended-course" style="margin-bottom: 5px">
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="select2-wrapper">
                                                    <select class="form-control course-select" name="course[]">
                                                        <option value="" selected>Select a course</option>
                                                        @foreach ($courses as $course)
                                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="select2-wrapper">
                                                    <select class="form-control period-select" name="period[]">
                                                        <option value="" selected>Select an academic period</option>
                                                        @foreach ($academicPeriods as $period)
                                                            <option value="{{ $period->id }}">{{ $period->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-10">
                                                <input type="number" class="form-control course-meetings" name="course-meetings[]">
                                            </div>

                                            <div class="col-md-1 col-sm-1 col-xs-2">
                                                <span class="fa fa-close side-icon course-remove" title="Remove Course" data-id="[id]"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <label>Population</label>
                                    <input type="text" name="size" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Unavailable Lecture Rooms</label>

                                    <div class="select2-wrapper">
                                        <select id="rooms-select" name="room_ids[]" class="form-control select2" multiple>
                                            <option value="">Select rooms</option>
                                            @foreach ($rooms as $room)
                                                <option value="{{ $room->id }}">{{ $room->name }}</option>
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
            $("#course-add").on("click", function () {
                var template = $("#course-template").html();
                var uniqueId = Date.now(); // Generate a unique identifier
                template = template.replace(/\[id\]/g, uniqueId);
                $("#courses-container").append(template);

                $("#courses-container .appended-course:last-child").removeClass("hidden");
            });
            $("#courses-container").on("click", ".course-remove", function () {
                $(this).closest(".course-form").remove();
            });
        });
    </script>
@endsection
