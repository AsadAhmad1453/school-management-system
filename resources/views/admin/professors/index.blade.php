@extends('admin.layout.master')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Professors list</h5>
            </div>
            <div class="col-md-6">
                <a href="{{route('professors.create')}}" class="btn btn-primary float-end m-3">Create</a>
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <table id="applicants_table" class="datatables-ajax table table-bordered ">
                <thead>
                <tr class="table-head">
                    <th style="width: 20%">Name</th>
                    <th style="width: 20%">Email</th>
                    <th style="width: 30%">Courses Taught</th>
                    <th style="width: 20%">Unavailable Periods</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($professors as $key => $professor)
                    <tr>
                        <td>{{ $professor->name }}</td>
                        <td>{{ $professor->email }}</td>
                        <td>
                            @if (count($professor->courses))
                                <ul>
                                    @foreach ($professor->courses as $course)
                                        <li>{{ $course->course_code . " " . $course->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No courses added yet</p>
                            @endif
                        </td>
                        <td>
                            @if (count($professor->unavailable_timeslots))
                                <ul>
                                    @foreach ($professor->unavailable_timeslots as $period)
                                        <li>{{ $period->day->name . " " . $period->timeslot->time }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No unavailable periods</p>
                            @endif
                        </td>
                        <td>
                          {{--  @can('permission-edit')--}}
                                <a href="{{route('professors.edit',$professor->id)}}" title="Edit" class="btn btn-outline-info btn-sm"><i class="fa fa-edit"></i></a>
                            {{--@endcan
                            @can('permission-delete')--}}
                                <form method="POST" action="{{route('professors.destroy',$professor->id)}}" class="d-inline">
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
