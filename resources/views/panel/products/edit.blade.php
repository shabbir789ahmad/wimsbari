@extends('panel.master')

@section('content')

<form action="{{ route('products.bulk.update') }}" method="POST" id="edit">

	@csrf
	<input type="hidden" name="id[]" value="{{$product->product_id}}">
	<input type="hidden" name="pbrand_id[]" value="{{$product->id}}">
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-md-3">
							<div class="form-group">
								<label for="">
									WhereHouse <span class="text-danger">*</span>
								</label>
								<select name="where_house_id"  class="form-control ">
									<option selected disabled >Select WhereHouse</option>
									@foreach($wherehouses as $wherehouse)
									<option value="{{ $wherehouse->id }}" @if($wherehouse->id == $product->where_house_id) selected @endif>{{ $wherehouse->where_house_name }}</option>
									@endforeach
								</select>
								<span class="text-danger small">@error ('where_house_id') <i class="fa fa-times-circle"></i>{{$message}} @enderror</span>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="form-group">
								<label for="">
									Brand
								</label>
								
								<select name="brand_id" id="brand_id" class="form-control">
									
									@foreach($brands as $brand)
									@if($brand->id == $product->brand_id) 
									<option value="{{ $brand->id }}" selected >{{ $brand->brand_name }}</option>
									@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="form-group">
								<label for="">
									Category
								</label>
								<select name="category_id" id="category_id" class="form-control">
									<option value="">Select Category</option>
									@foreach($categories as $category)
									<option value="{{ $category->id }}" @if($category->id == $product->category_id) selected @endif>{{ $category->category_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-12 col-md-3">
							<div class="form-group">
								<label for="">
									Sub Category
								</label>
								<select name="sub_category_id" id="sub_category_id" class="form-control">
									<option value="">Select Sub Category</option>
									@foreach($sub_categories as $sub_category)
									<option value="{{$sub_category->id }}" @if($sub_category->id == $product->sub_category_id) selected @endif>{{ $sub_category->sub_category_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="">
									Product Name<span class="text-danger">*</span>
								</label>
								<x-forms.input name="name[]" value="{{ $product->product_name }}"></x-forms.input>
							</div>
						</div>
					
					
					  <div class="col-12 col-md-6">
							<div class="form-group">
								<label for="">
									 Price Per Component<span class="text-danger">*</span>
								</label>
								<x-forms.input name="product_price_piece[]" value="{{ $stock->product_price_piece }}"></x-forms.input>
							</div>
						</div>
						
					</div>
					<div class="row">
						
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="">
									Stock<span class="text-danger">*</span>
								</label>
								<x-forms.input name="stock[]" value="{{ $stock->stock }}"></x-forms.input>
							</div>
						</div>
						
						<div class="col-12 col-md-6">
							<div class="form-group">
								<label for="">
									Purchasing Price<span class="text-danger">*</span>
								</label>
								<x-forms.input name="purchasing_price[]" value="{{ $stock->purchasing_price }}"></x-forms.input>
							</div>
						</div>

					</div>
					@if($product['product_qualities'])
					@php $qulaities=json_decode($product['product_qualities']) @endphp
                    <div class="row">
					  <div class="col-md-3">
                       <div class="form-group">
						 <label for="">Product Color</label>
						 <x-forms.input name="product_color" value="{{$qulaities->color}}"></x-forms.input>
						</div>
					  </div>
                      <div class="col-md-3">
                       <div class="form-group">
						 <label for="">Product Size</label>
						 <x-forms.input name="product_size" value="{{$qulaities->size}}"></x-forms.input>
						</div>
					  </div>
					  <div class="col-md-3">
                       <div class="form-group">
						 <label for="">Product Modal</label>
						 <x-forms.input name="prodcut_modal" value="{{$qulaities->modal}}"></x-forms.input>
						</div>
					  </div>
					  <div class="col-md-3">
                       <div class="form-group">
						 <label for="">Product Thickness</label>
						 <x-forms.input name="prodcut_thickness" value="{{$qulaities->thickness}}"></x-forms.input>
						</div>
					  </div>
					</div>
					@endif
					<div class="row">
						<div class="col-12">
							<button type="button" id="edit_button_submit" class="btn btn-primary">
								Save
							</button>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</form>

@endsection

@section('script')

@parent

<script>

	$(document).ready(function() {
		
		$('#category_id').change(function() {
			
			$.ajax({
				url: baseURL + `categories/${ $(this).val() }/sub-categories`,
			})
			.done(function(res) {

				$('#sub_category_id').empty();
				$('#sub_category_id').append(`<option value="">Select Sub Category</option>`);
				
				$.each(res, function(index, val) {
					
					$('#sub_category_id').append(`

						<option value="${ val.id }">${ val.sub_category_name }</option>

					`);

				});

			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});
	});


$(document).ready(function() 
{
    var barcode="";
    $('#bar_code').keydown(function(e) 
    {
        $(this).find('[autofocus]').focus();
            barcode=barcode+String.fromCharCode(code);
            $(this).val(barcode)
        
    });
});
$('#edit_button_submit').click(function(){

	$('#edit').submit();
})
</script>

@endsection