@extends('admin.layout.master')

@section('style')
    <link rel="stylesheet" href="{{asset('admin/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('admin/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-header">Users List</h5>
            </div>
            <div class="col-md-6">
                <a href="{{route('users.create')}}" class="btn btn-primary float-end m-3">Create</a>
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <table id="applicants_table" class="datatables-ajax table table-bordered ">
                <thead>
                <tr>

                    <th>#</th>
                    <!--                                <th>Image</th>-->
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Roles</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ $user->id }}</td>

                        {{--@if($user->type=="admin")
                            <td><images class="images-fluid user_image" src="{{($user->image!=null) ? asset('/images/faculty/'.$user->image) : asset('images/imglogo.jpg')}}" ></td>
                        @else
                            <td><images class="images-fluid user_image" src="{{($user->image!=null) ? asset('/applicants/images/'.$user->image) : asset('images/imglogo.jpg')}}" ></td>
                        @endif--}}
                        <td>{{ $user->name}}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{$user->type}}</td>
                        <td>@if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <label class="badge bg-label-info">{{ $v }}</label>
                                @endforeach
                            @endif</td>
                        <td>{{date("d-M-Y",strtotime($user->created_at))}}</td>
                        <td>
                            @can('user-edit')
                                <a class="btn btn-outline-info btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('user-delete')
                                <form method="POST" action="{{route('users.destroy',$user->id)}}" class="d-inline">
                                    @csrf()
                                    @method('DELETE')
                                    <button type="submit" class="delete btn btn-outline-danger  btn-sm"><i class="fa fa-delete-left"></i></button>
                                </form>
                            @endcan
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
