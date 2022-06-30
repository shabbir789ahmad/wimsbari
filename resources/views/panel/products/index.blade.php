@extends('panel.master')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="form-group">
			<div class="btn-group" role="group" aria-label="Basic example">
				
                  <a href="{{ route('products.create') }}" class="btn btn-primary">
					Create Components
				</a>
			
			</div>
		</div>
	</div>
</div>
<div class="row">
 <div class="col-md-4">
     <x-same-code  :categories="$categories" />
 </div>
 <div class="col-12 col-md-4">
   <div class="form-group">
    <label for="">Search by Sub Category <span class="text-danger">*</span>
    </label>
    <select name="sub_category_id[]" id="sub_category_id" class="form-control sub_category_id " multiple>
        @if(request()->query('sub_category'))

        @foreach($sub_categories as $subcategory)
        <option value="{{$subcategory['id']}}" @if(request()->query('sub_category')==$subcategory->id) selected @endif>{{$subcategory['sub_category_name']}}</option>
        @endforeach
        @endif
    </select>
   </div>
  </div>
  <div class="col-md-4">
    <x-same-code2  :brands="$brands"/>
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
								<th scope="col">Brand</th>
								<th scope="col">Name </th>
								<th scope="col">Category</th>
								<th scope="col">Sub Category</th>
								<th scope="col">Stock</th>
								<th scope="col">Sold</th>
								<th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        	
        	@foreach($products as $product)

        	
            <tr>
								
								<td class="p-0 col-1">
									<img src="{{ asset('uploads/products/' . $product->product_image) }}"  alt="product image" class="border border-danger" width="80px" height="100%"  loading="lazy">
								</td>
								<td >
									<select class="form-control brands">
										@foreach($brands as $brand)
									  	@foreach($product->brand as $b)
										@if($b->brand_id ==  $brand['id'] )
										<option value="{{$b['id']}}">{{$brand['brand_name']}}</option>
										@endif
									
									  @endforeach
									  @endforeach
									</select>
								</td>
								<td >{{ $product->product_name }}
									@if($product->product_qualities)
									@php $qualitiy=json_decode( $product->product_qualities); @endphp
									{{$qualitiy->size}}
									<p><span class="font-weight-bold">Color:</span> {{$qualitiy->color}},<span class="font-weight-bold">Modal:</span>  {{$qualitiy->modal}},<span class="font-weight-bold">Thickness:</span>{{$qualitiy->thickness}}</p>
									@endif
								</td>
									
							
								<td>
									{{ $product->category_name }}
								</td>
								<td>
									{{ $product->sub_category_name }}
								</td>
								<td>
									<select class="form-control">
										@foreach($stocks as $stock)
									@foreach($product->brand as $b)
									@if($stock['pbrand_id'] == $b['id'])
                   <option>{{$stock['stock']}}</option>
                  @endif
									@endforeach
									@endforeach
										
									</select>
									
								</td>
								<td>
									<select class="form-control">
										@foreach($stocks as $stock)
									@foreach($product->brand as $b)
									@if($stock['pbrand_id'] == $b['id'])
									@if($stock['stock_sold']==Null || $stock['stock_sold']=='')
                   <option>0</option>
									@else
                   <option>{{$stock['stock_sold']}}</option>
                  @endif
                  @endif
									@endforeach
									@endforeach
										
									</select>
								</td>
								<td class="col-1">
									<div class="d-flex">
								  <a href="{{ route('products.edit', ['product' => $product->id]) }}" type="submit" class="btn btn-xs btn-info">
										Edit
									</a>
									
								</div>
									<div class="d-flex">
									<form  action="{{ route('stock.index')}}" method="GET" class="stock_form " >
										@csrf
										<input type="hidden" name="id" value="{{$product->id}}">
								   <button class="btn btn-info btn-xs stc" >Stock</button>
								  </form>
									<form action="{{ route('products.destroy', ['product' => $product->id]) }}" method="POST" class="ml-1" onsubmit="return confirmDelete()">
										@method('DELETE')
										@csrf
										<button type="submit" class="btn btn-xs btn-danger">
											Delete
										</button>
								
									</form>
								</div>
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






<form id="sub_category_form">
	<input type="hidden" name="sub_category" id="sub_category">
	<input type="hidden" name="brand_se" id="brand_se">
</form>
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

  $('#sub_category_id').change(function(e){
  	e.preventDefault();
  	let id=$(this).val()
  	$('#sub_category').val(id)
  	$('#sub_category_form').submit()
  });

  $('#brand_search').change(function(e){
  	e.preventDefault();

  	let ids=$('#sub_category_id').val()
  	$('#sub_category').val(ids)
  	let id=$(this).val()
  	$('#brand_se').val(id)
  	$('#sub_category_form').submit()
  });

// $('.show-field').click(function(){

//  $(this).siblings().css('display','block')
//  $(this).css('display','none')
// });



$('.stock_form').on('submit', function(){

 let brand= $(this).parents('td').siblings('td').find('.brands').val();
$(this).children('.brnd').val(brand)
});
</script>
@endsection