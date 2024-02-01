@extends('admin.layout.master')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Roles List</h5>
            </div>
            <div class="col-md-6">
                <a href="{{route('roles.create')}}" class="btn btn-primary float-end m-3">Create</a>
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <table id="applicants_table" class="datatables-ajax table table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th width="280px">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('roles.show',$role->id) }}"><i class="fa fa-book"></i></a>
                            {{--@can('role-edit')--}}
                                <a class="btn btn-outline-info btn-sm" href="{{ route('roles.edit',$role->id) }}"><i class="fa fa-edit"></i></a>
                           {{-- @endcan
                            @can('role-delete')--}}
                                <form method="POST" action="{{route('roles.destroy',$role->id)}}" class="d-inline">
                                    @csrf()
                                    @method('DELETE')
                                    <button  type="submit" class="delete btn btn-outline-danger  btn-sm" ><i class="fa fa-delete-left"></i></button>
                                </form>
                           {{-- @endcan--}}
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
