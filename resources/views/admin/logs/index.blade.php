@extends('admin.layout.master')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Logs</h5>
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <table id="applicants_table" class="datatables-ajax table table-bordered ">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>User Name</th>
                    <th>Operation</th>
                    <th>Date</th>
                </tr>
                </thead>
                @foreach($data as $str)
                    <tr>
                        <td>{{$str->id}}</td>
                        <td>{{$str->student->name}}</td>
                        <td>{{$str->user->name}}</td>
                        <td>{{$str->operation}}</td>
                        <td>{{date("d-M-Y",strtotime($str->created_at))}}</td>
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
