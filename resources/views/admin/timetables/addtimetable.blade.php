@extends('admin.layout.master')

@section('content')
<div class="container">
	<div class="row">
		<form method="POST" action="{{}}">
			@csrf
			<div class="col-12">
				<h3>Working days</h3>
			</div>
			<div class="col-12 d-flex">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
					<label class="form-check-label" for="flexCheckDefault">
						Monday
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
					<label class="form-check-label" for="flexCheckDefault">
					 	Tuesday
					</label>
				</div>
			</div>
		</form>
		
	</div>
</div>
@endsection