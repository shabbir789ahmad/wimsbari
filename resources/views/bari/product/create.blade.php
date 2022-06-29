@extends('bari.master')
@section('content')

<form action="{{ route('bari.product.store') }}" method="POST" enctype="multipart/form-data" id="create_edit">
	@csrf
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="">
									Brand <span class="text-danger">*</span>
								</label>
			<select name="bri_brand_id" class="form-control ">
			<option selected disabled >Select Brand</option>
									@foreach($brands as $brand)
									<option value="{{ $brand->id }}" {{ old('brand_id')== $brand->id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
									@endforeach
								</select>
								<span class="text-danger small">@error ('brand_id') <i class="fa fa-times-circle"></i>{{$message}} @enderror</span>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group">
				<label for="">
						Category <span class="text-danger">*</span>
				</label>
				<select name="bri_category_id" id="bari_category_id" class="form-control">
									<option selected disabled >Select Category</option>
									@foreach($categories as $category)
									<option value="{{ $category->id }}" {{ old('category_id')== $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
									@endforeach
								</select>
								<span class="text-danger small">@error ('category_id') <i class="fa fa-times-circle"></i>{{$message}} @enderror</span>
							</div>
						</div>
						
					</div>
					<div class="row" id="form_feild">
						
						
						
						
						
					</div>
					@if(request()->is('bari/quotation/create'))
                    <input type="hidden" name="quotation" value="1">
					@endif
					
					<div class="row">
						<div class="col-12">

							@if(request()->is('bari/quotation/create'))
							<button type="submit" id="create_button_submit" class="btn btn-primary" >
								Create Quotation
							</button>
							@else
							<button type="submit" id="create_button_submit" class="btn btn-primary" >
								Save
							</button>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

@endsection


