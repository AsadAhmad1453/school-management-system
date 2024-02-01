@extends('admin.layout.master')
@section('content')
    <div class="row mb-4">
        <div class="col-md">
            <div class="card">
                <h5 class="card-header">Rooms</h5>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="post" action="{{route('rooms.update',$room->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $room->name) }}"  maxlength="35"  placeholder="Image Name" autofocus required>
                                </div>
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacity</label>
                                    <input type="text" class="form-control" id="capacity" name="capacity" value="{{ old('capacity', $room->capacity) }}"  maxlength="35"  placeholder="Image Name" autofocus required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
