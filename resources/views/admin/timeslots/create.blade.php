@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <hr class="my-0">
                <div class="card-body">
                    <form id="formAccountSettings" action="{{ route('timeslots.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="select2-wrapper">
                                    <label>Start Time</label>
                                    <select id="from-select" name="from" class="form-control select2">
                                        @for($i = 0; $i <= 23; $i++)
                                            @foreach(['00', '30'] as $subPart)
                                                <option value="{{ (($i < 10) ? "0" : "") . $i . ":" . $subPart }}">
                                                    {{ (($i < 10) ? "0" : "") . $i . ":" . $subPart }}
                                                </option>
                                            @endforeach
                                        @endfor
                                    </select>
                                </div>
                                <div class="select2-wrapper">
                                    <label>End Time</label>
                                    <select id="to-select" name="to" class="form-control select2">
                                        @for($i = 0; $i <= 23; $i++)
                                            @foreach(['00', '30'] as $subPart)
                                                <option value="{{ (($i < 10) ? "0" : "") . $i . ":" . $subPart }}">
                                                    {{ (($i < 10) ? "0" : "") . $i . ":" . $subPart }}
                                                </option>
                                            @endforeach
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
