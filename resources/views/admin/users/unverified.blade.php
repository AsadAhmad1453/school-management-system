@extends('admin.layout.master')
@section('content')
    <!-- HTML (DOM) sourced data -->
    <section id="html">
        <div class="action_display">
            <div class="col-sm-8 col-lg-4 col-md-8" style="margin: 0 auto; float: unset;">

                @if(!empty(session()->get('success')))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session()->get('success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @elseif(session()->get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session()->get('error')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @elseif(session()->has('errors'))
                    @foreach($errors->default->messages() as $messages)
                        {{--@foreach($messages as $message)--}}

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{$messages[0]}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endforeach
                    {{--@break--}}
                    {{--@endforeach--}}
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Users list</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                @can('program-list')
                                    <a href="{{route('post.emails',3)}}" style="margin-right: 10px" title="Bulk send Pending fee emails"
                                       class="btn btn-info float-left"  onclick="return confirm('Are you sure?')"> Unverified Users</a>

                                    <a href="{{route('unverified.user.export')}}" style="margin-right: 10px" title="Bulk send Pending fee emails"
                                       class="btn btn-info float-left"  onclick="return confirm('Are you sure?')"> Export</a>
                                @endcan
                                <li>
                                    @can('user-create')
                                        <a href="{{route('users.create')}}" class="btn btn-info"><i class="icon-plus"></i> </a>
                                    @endcan
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <table class="table table-striped table-bordered sourced-data text-nowrap">
                            <thead>
                            <tr>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i=0 @endphp
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name}}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{date("d-M-Y",strtotime($user->created_at))}}</td>
                                    <td>
                                        @can('user-edit')
                                            <a class="btn btn-info btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="icon-pencil"></i></a>
                                        @endcan
                                        @can('user-delete')
                                            <form method="POST" action="{{route('users.destroy',$user->id)}}" class="d-inline">
                                                @csrf()
                                                @method('DELETE')
                                                <button type="submit" class="delete btn btn-outline-danger  btn-sm"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
