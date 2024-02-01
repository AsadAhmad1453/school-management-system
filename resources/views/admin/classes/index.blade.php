@extends('admin.layout.master')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Classes list</h5>
            </div>
            <div class="col-md-6">
                <a href="{{route('classes.create')}}" class="btn btn-primary float-end m-3">Create</a>
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <table id="applicants_table" class="datatables-ajax table table-bordered ">
                <thead>
                <tr class="table-head">
                    <th style="width: 30%">Name</th>
                    <th style="width: 10%">Size</th>
                    <th style="width: 30%">Courses</th>
                    <th style="width: 20%">Unavailable Rooms</th>
                    <th style="width: 10%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($classes as $class)
                    <tr>
                        <td>{{ $class->name }}</td>
                        <td>{{ $class->size }}</td>
                        <td>
                            @foreach ($academicPeriods as $period)
                                {{ $period->name }}
                                    <?php $courses = $class->courses()->wherePivot('academic_period_id', $period->id)->get(); ?>
                                @if (count($courses))
                                    <ul>
                                        @foreach ($courses as $course)
                                            <li>{{ $course->course_code . " " . $course->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No courses added for this period</p>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @if (count($class->unavailable_rooms))
                                <ul>
                                    @foreach ($class->unavailable_rooms as $room)
                                        <li>{{ $room->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                None specified
                            @endif
                        </td>
                        <td>
                          {{--  @can('permission-edit')--}}
                                <a href="{{route('classes.edit',$class->id)}}" title="Edit" class="btn btn-outline-info btn-sm"><i class="fa fa-edit"></i></a>
                            {{--@endcan
                            @can('permission-delete')--}}
                                <form method="POST" action="{{route('classes.destroy',$class->id)}}" class="d-inline">
                                    @csrf()
                                    @method('DELETE')
                                    <button type="submit" class="delete btn btn-outline-danger  btn-sm"><i class="fa fa-delete-left"></i></button>
                                </form>
                            {{--@endcan--}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection

@section('script')

    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script>
        $('#applicants_table').DataTable({
            "order": [[0, "desc"]],
            aLengthMenu: [
                [15, 30, 50, 100, 200, -1],
                [15, 30, 50, 100, 200, "All"],
            ],
            iDisplayLength: 15,
            "autoWidth": false
        });
    </script>
@endsection
