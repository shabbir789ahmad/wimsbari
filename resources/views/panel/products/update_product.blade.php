@extends('panel.master')
@section('content')

<form action="{{ route('products.bulk.update') }}"  method="POST" enctype="multipart/form-data">
	@csrf

<div class="card" >
	<div class="card-body">
   <div class="row">
  	<div class="col-12 col-md-4">
				<div class="form-group">
					<label for="">
					 Product Brand<span class="text-danger">*</span>
					</label>
					<select class="form-control " id="brand"  name="">
						@foreach($brands as $brand)
						<option value="{{$brand['id']}}">{{$brand['brand_name']}}</option>
						@endforeach
					</select>
					
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="form-group">
					<label for="">
						Product Category <span class="text-danger">*</span>
					</label>
					<select class="form-control " name="category_id[]">
						@forelse($categories as $category)
						@foreach($products as $product)
						@if($product['category_id']==$category['id'])
						@if($loop->first)
						<option value="{{$category['id']}}">{{$category['category_name']}}</option>
            @endif
            @endif
						@endforeach
						@empty

						@endforelse
					</select>
				</div>
			</div>
      <div class="col-12 col-md-4">
				<div class="form-group">
					<label for="">
						Product Sub category<span class="text-danger">*</span>
					</label>
					<select class="form-control sub_cat_form" >
						@forelse($sub_categories as $sub_category)
						@foreach($products as $product)
						@if($product['sub_category_id']==$sub_category['id'])

						<option value="{{$sub_category['id']}}" >{{$sub_category['sub_category_name']}}</option>
						
						@endif
						@endforeach
						@empty

						@endforelse
					</select>
				</div>
			</div>
		
    </div>
	</div>
</div>
<div id="product-field" class="col-12">
  <div class="row">
	  <div class="col-12 ">
		  <div class="card">
			  <div class="card-body pb-0">
				  <div class="form-group">
					  <x-btn.save type="submit"></x-btn.save>
				  </div>
			  </div>
		  </div>
	  </div>
  </div>
</div>
<!--product-->
 <div class="row">
  <div class="col">
   @if($products)
   @foreach($products as $product)
   <div class="card mt-5">
	 <div class="card-body">
	 	<div class="row d-none">
	 		<div class="col-12 col-md-4">
				<div class="form-group">
					<input type="text" class="" name="id[]" value="{{$product['id']}}">
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="form-group">
					@if($product->brand)
					<input type="text" name="pbrand_id[]" value="{{$product->brand->id}}" class="form-control"  >
					@else
            <input type="text" name="pbrand_id[]"  value="" class="form-control"  >
					@endif
				</div>
			</div>
		
		 </div>
	   <div class="row">
			<div class="col-12 col-md-6">
				<div class="form-group">
					<label for="">
						Product Name <span class="text-danger">*</span>
					</label>
					<x-forms.input name="name[]" value="{{$product['product_name']}}"></x-forms.input>
				</div>
			</div>
			
			<div class="col-12 col-md-6 ">
				<div class="form-group">
					<label for="">
						 Price Per Component  <span class="text-danger">*</span>
					</label>
					@if($product->brand)
					<x-forms.input name="product_price_piece[]" value="{{\App\Models\ProductStock::where(['pbrand_id' => $product->brand->id])->pluck('product_price_piece')->first()}}"></x-forms.input>
					@else
           <x-forms.input name="product_price_piece[]" value=""></x-forms.input>
					@endif
				</div>
			</div>

			<div class="col-12 col-md-6">
				<div class="form-group">
					<label for="">
						Component Stock<span class="text-danger">*</span>
					</label>
				    <input type="text" name="stock[]" value=" {{\App\Models\ProductStock::where(['pbrand_id' => $product->brand->id])->pluck('stock')->first()}} " class="form-control">
				</div>
			</div>

			<div class="col-12 col-md-6">
				<div class="form-group">
					<label for="">
						Purchasing Price<span class="text-danger">*</span>
					</label>
					@if($product->brand)
					<input type="text" name="purchasing_price[]" value="{{\App\Models\ProductStock::where(['pbrand_id' => $product->brand->id])->pluck('purchasing_price')->first()}}" class="form-control">
					@else
           <input type="text" name="purchasing_price[]" value="" class="form-control">

					@endif
				</div>
			</div>
		 </div>
		
		
	 </div>
	</div>
	@endforeach
	@endif
	</div>
  </div>
</form>


@endsection
@section('script')

@parent

<script type="text/javascript">
	
	$('#brand').change(function(){
   
    let brand=$(this).val()
    let text=$("#brand option:selected").text();
    $('#b_id').val(brand)
    $('#b').val(text)
   
	});
</script>

@endsection