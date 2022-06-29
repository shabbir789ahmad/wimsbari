@extends('panel.master')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="form-group">
			<div class="btn-group" role="group" aria-label="Basic example">
				
			
			 <a href="{{ route('bari.quotation.create') }}" class="btn btn-primary ml3">
					Create 
				</a>

				
			</div>
		</div>
	</div>
</div>
<div class="row">
 <div class="col-md-4">
     <x-same-code  :categories="$categories" />
 </div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			
			<div class="card-body pb-0">
				<form action="{{ route('bari.quotation.make') }}" method="GET"> 
				 <button  class="btn btn-primary mb-3">
					Create Quotation
				</button>	
				@if(count($products) > 0)

				<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
           <tr>
            <th scope="col"><input type="checkbox" id="check_all" ></th>
            </form>
            <th scope="col">Image</th>
	        <th scope="col">Product</th>
	        <th scope="col">Size</th>
	        <th scope="col">Rate/Price</th>
	        <th scope="col">Category</th>
	        <th scope="col">Brand</th>
	        <th scope="col"></th>
           </tr>
        </thead>
        <tbody>
        	
        	@foreach($products as $product)
        	

        <tr>
        	<td><input type="checkbox" name="product_id[]" value="{{$product['id']}}" class="product_id_check"></td>
		  <td class=" col-1">
			<img src="{{ asset('uploads/brand/' . $product->bri_image) }}"  alt="product image" class="border " width="100%" height="60rem"  loading="lazy">
		  </td>
		 
		  <td class="col-6 align-middle">
			<h3 class="font-weight-bold">{{ $product->bri_product_name }}</h3><p> With
        @foreach($product->components as $component)
		   {{ $component->bri_quentity }} {{ $component->category_name }} 
		   +
		 @endforeach</p>
		 </td>
		 <td class="align-middle text-center">{{ $product->size }}</td>
		 <td class="align-middle text-center">{{ $product->rate }}/-</td>
		 <td class="align-middle text-center">{{ $product->category_name }}</td>
		 <td class="align-middle text-center">{{ $product->brand_name }}</td>

		 <td class=" d-flex ">
		 
			<a href="{{ route('bari.quotation.edit', ['id' => $product->id]) }}" type="submit" class="btn btn-md btn-info mt-4">
			Edit
			</a>
			
		
		<form action="{{ route('bari.product.delete', ['id' => $product->id]) }}" method="POST" class="ml-1" onsubmit="return confirmDelete()">
		@method('DELETE')
		@csrf
		<button type="submit" class="btn btn-md btn-danger mt-4">
			Delete
		</button>
								
		</form>
		</td>
							</tr>
      
            
            @endforeach
        </tbody>
    </table>
  
				
				 
				@else
				<x-alert.resource-empty resource="products" new="products.create-bulk"></x-alert.resource-empty>
				@endif			
			</div>
		</form>
		</div>
	</div>
</div>






@endsection
@section('script')

@parent

<script type="text/javascript">



 $('#check_all').change(function(){

 	if($(this).prop('checked'))
 	{
 		 $('.product_id_check').prop('checked',true)
      
 	}else
 	{
      $('.product_id_check').prop('checked',false)
 	}
 })
 

</script>
@endsection