@extends('admin.layout.master')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Rooms list</h5>
            </div>
            <div class="col-md-6">
                <a href="{{route('timeslots.create')}}" class="btn btn-primary float-end m-3">Create</a>
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <table id="applicants_table" class="datatables-ajax table table-bordered ">
                <thead>
                <tr class="table-head">
                    <th style="width: 90%">Period</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($timeslots as $timeslot)
                    <tr>
                        <td>{{ $timeslot->time }}</td>
                        <td>
                            {{--  @can('permission-edit')--}}
                            <a href="{{route('timeslots.edit',$timeslot->id)}}" title="Edit" class="btn btn-outline-info btn-sm"><i class="fa fa-edit"></i></a>
                            {{--@endcan
                            @can('permission-delete')--}}
                            <form method="POST" action="{{route('timeslots.destroy',$timeslot->id)}}" class="d-inline">
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
