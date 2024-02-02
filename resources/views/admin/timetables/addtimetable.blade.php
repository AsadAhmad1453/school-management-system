@extends('admin.layout.master')

@section('content')
<div class="container">
	<form method="POST" action="{{}}">
		@csrf
		<div class="row">
				<div class="col-12">
					<h3>Working days</h3>
				</div>
				<div class="col-12">
					<div class="row ">
						<div class="col-1">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label" for="flexCheckDefault">
									Monday
								</label>
							</div>
						</div>	
						<div class="col-1">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label" for="flexCheckDefault">
								Tuesday
								</label>
							</div>
						</div>
						<div class="col-1">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label" for="flexCheckDefault">
								wednesday
								</label>
							</div>
						</div>
						<div class="col-1">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label" for="flexCheckDefault">
								Thursday
								</label>
							</div>
						</div>
						<div class="col-1">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label" for="flexCheckDefault">
								Friday
								</label>
							</div>
						</div>
				

					
						<div class="col-1">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label" for="flexCheckDefault">
								Saturday
								</label>
							</div>
						</div>
						<div class="col-1">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label" for="flexCheckDefault">
								Sunday
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 mt-2">
					
					<div class="form-group">
						<label for="exampleInputEmail1">Week Plan</label>
						<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
					
					</div>


				</div>	
		</div>
		<div class="row">
			<div class="col-12 mt-3">
				<h3>Periods</h3>

			</div>
			<div class="col-6" style="border: 2px solid blacks;">
				<label for="inputPassword5" class="form-label">Lesson Duration </label>
				<input type="text" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
			</div>
			<div class="col-6">
				<label for="inputPassword5" class="form-label">Bell Duration</label>
				<input type="text" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
			</div>
		</div>
	</form>
</div>
@endsection