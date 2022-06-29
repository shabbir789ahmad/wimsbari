@extends('panel.master')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="form-group">
			<div class="btn-group" role="group" aria-label="Basic example">
				
			
			 <a href="{{ route('bari.create') }}" class="btn btn-primary ml3">
					Create Product
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
				@if(count($products) > 0)

				<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
           <tr>
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
		  <td class=" col-2">
			<img src="{{ asset('uploads/brand/' . $product->bri_image) }}"  alt="product image" class="border border-danger" width="100%" height="100rem"  loading="lazy">
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

		 <td class="col-1 d-flex ">
		 
			<a href="{{ route('bari.edit', ['id' => $product->id]) }}" type="submit" class="btn btn-md btn-info mt-4">
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
				<x-alert.resource-empty resource="products" new="bari.index"></x-alert.resource-empty>
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

$(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false
    } );
});

 

</script>
@endsection