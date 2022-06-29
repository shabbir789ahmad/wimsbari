@extends('panel.master')

@section('content')

<form action="{{ route('wherehouse.store') }}" method="POST">
	@csrf
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<div class="row">
							<div class="col-12 col-md-6">

                             <label for="">
							  Where House Name <span class="text-danger">*</span>
						     </label>
						     <x-forms.input name="where_house_name" placeholder=" WhereHouse Name"></x-forms.input>
						     <span class="text-danger">@error ('where_house_name') {{ $message }} @enderror</span>
							</div>
							<div class="col-12 col-md-6">
                              <label for="" class="">
							    Where House Location <span class="text-danger">*</span>
						      </label>
						      <input type="text" name="where_house_location"  class="form-control" placeholder=" WhereHouse Location">
						<span class="text-danger">@error ('where_house_location') {{ $message }} @enderror</span>
							</div>
							
							
							
							
						</div>
						
						
						
					</div>
					<x-btn.save></x-btn.save>
				</div>
			</div>
		</div>
	</div>
</form>

@endsection