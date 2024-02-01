@extends('admin.layout.master')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Courses list</h5>
            </div>
            <div class="col-md-6">
                <a href="{{route('courses.create')}}" class="btn btn-primary float-end m-3">Create</a>
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <table id="applicants_table" class="datatables-ajax table table-bordered ">
                <thead>
                <tr class="table-head">
                    <th style="width: 30%">Course Code</th>
                    <th style="width: 30%">Name</th>
                    <th style="width: 30%">Taught By</th>
                    <th style="width: 10%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($courses as $key => $course)
                    <tr>
                        <td>{{ $course->course_code }}</td>
                        <td>{{ $course->name }}</td>
                        <td>
                            <ul>
                                @foreach ($course->professors as $professor)
                                    <li>{{ $professor->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                          {{--  @can('permission-edit')--}}
                                <a href="{{route('courses.edit',$course->id)}}" title="Edit" class="btn btn-outline-info btn-sm"><i class="fa fa-edit"></i></a>
                            {{--@endcan
                            @can('permission-delete')--}}
                                <form method="POST" action="{{route('courses.destroy',$course->id)}}" class="d-inline">
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
