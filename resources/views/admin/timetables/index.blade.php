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
                <form method="post" action="{{ route('timetables.store') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary float-end m-3">Create Timetable</button>
                </form>
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <table id="applicants_table" class="datatables-ajax table table-bordered ">
                <thead>
                <tr class="table-head">
                    <td>Timetable Name</td>
                    <td>Status</td>
                    <td style="width: 10%">Print</td>
                </tr>
                </thead>
                <tbody>
                @foreach($timetables as $timetable)
                    <tr>
                        <td>{{ $timetable->name }}</td>
                        <td>{{ $timetable->status }}</td>
                        <td>
                            @if($timetable->file_url)
                                <a href="{{ route('timetables.view', ['id' => $timetable->id]) }}" class="btn btn-sm btn-primary print-btn" data-id="{{ $timetable->id }}">
                                    <span class="fa fa-print"></span> PRINT
                                </a>
                            @else
                                N/A
                            @endif
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
